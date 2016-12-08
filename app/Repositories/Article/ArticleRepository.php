<?php

namespace App\Repositories\Article;

use App\Models\Article;
use Config;
use Response;
use App\Models\Tag;
use App\Models\Category;
use Str;
use Event;

use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;
use File;
use App\Repositories\RepositoryAbstract;
use App\Repositories\CrudableInterface as CrudableInterface;
use App\Exceptions\Validation\ValidationException;

/**
 * Class ArticleRepository.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class ArticleRepository extends RepositoryAbstract implements ArticleInterface, CrudableInterface
{
	protected $width;
	protected $height;
	protected $thumbWidth;
	protected $thumbHeight;
	protected $loopWidth;
	protected $loopHeight;
	protected $imgDir;
	protected $thumbDir;
	protected $loopDir;
	protected $perPage;
	protected $article;


	/**
	 * Rules.
	 *
	 * @var array
	 */
	protected static $rules = [
		'title'   => 'required',
		'content' => 'required',
	];

	/**
	 * @param Article $article
	 */
	public function __construct(Article $article)
	{
		$config = Config::get('grace');
		$this->perPage = $config['per_page'];
		$this->width = $config['modules']['article']['image_size']['width'];
		$this->height = $config['modules']['article']['image_size']['height'];
		$this->thumbWidth = $config['modules']['article']['thumb_size']['width'];
		$this->thumbHeight = $config['modules']['article']['thumb_size']['height'];
		$this->loopWidth = $config['modules']['article']['loop_size']['width'];
		$this->loopHeight = $config['modules']['article']['loop_size']['height'];
		$this->imgDir = $config['modules']['article']['image_dir'];
		$this->thumbDir = $config['modules']['article']['thumb_dir'];
		$this->loopDir = $config['modules']['article']['loop_dir'];
		$this->article = $article;
	}

	/**
	 * @return mixed
	 */
	public function all()
	{
		return $this->article->with('tags')->orderBy('created_at', 'DESC')->where('is_published', 1)->where('lang', $this->getLang())->get();
	}

	/**
	 * @param $limit
	 *
	 * @return mixed
	 */
	public function getLastArticle($limit)
	{
		return $this->article->orderBy('created_at', 'desc')->where('lang', $this->getLang())->take($limit)->offset(0)->get();
	}

	/**
	 * @return mixed
	 */
	public function lists()
	{
		return $this->article->get()->where('lang', $this->getLang())->lists('title', 'id');
	}


	/**
	 * Get paginated articles.
	 *
	 * @param int  $page  Number of articles per page
	 * @param int  $limit Results per page
	 * @param bool $all   Show published or all
	 *
	 * @return StdClass Object with $items and $totalItems for pagination
	 */
	public function paginate($page = 1, $limit = 10, $all = false)
	{
		$result = new \StdClass();
		$result->page = $page;
		$result->limit = $limit;
		$result->totalItems = 0;
		$result->items = [];

		$query = $this->article->with('tags')->orderBy('created_at', 'DESC')->where('lang', $this->getLang());

		if(!$all){
			$query->where('is_published', 1);
		}

		$articles = $query->skip($limit * ($page - 1))->take($limit)->get();

		$result->totalItems = $this->totalArticles($all);
		$result->items = $articles->all();

		return $result;
	}

	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function find($id)
	{
		return $this->article->with(['tags', 'category'])->findOrFail($id);
	}

	/**
	 * @param $slug
	 *
	 * @return mixed
	 */
	public function getBySlug($slug)
	{
		return $this->article->with(['tags', 'category'])->where('slug', $slug)->first();
	}

	/**
	 * @param $attributes
	 *
	 * @return bool|mixed
	 *
	 * @throws \App\Exceptions\Validation\ValidationException
	 */
	public function create($attributes)
	{
		$attributes['is_published'] = isset($attributes['is_published']) ? true : false;

		if($this->isValid($attributes)){

			$file = null;
			if(isset($attributes['image'])){
				$file = $attributes['image'];
			}
			if($file){


				$destinationPath = public_path() . $this->imgDir;
				$destinationThumbPath = public_path() . $this->thumbDir;
				$destinationLoopPath = public_path() . $this->loopDir;

				File::exists($destinationPath) or File::makeDirectory($destinationPath);
				File::exists($destinationThumbPath) or File::makeDirectory($destinationThumbPath);
				File::exists($destinationLoopPath) or File::makeDirectory($destinationLoopPath);


				File::delete($destinationPath . $this->article->file_name);
				File::delete($destinationThumbPath . $this->article->file_name);
				File::delete($destinationLoopPath . $this->article->file_name);

				$destinationPath = public_path() . $this->imgDir;
				$destinationThumbPath = public_path() . $this->thumbDir;
				$destinationLoopPath = public_path() . $this->loopDir;

				$fileName = $file->getClientOriginalName();
				$fileSize = $file->getClientSize();
				$upload_success = $file->move($destinationPath, $fileName);

				if($upload_success){
					Image::make($destinationPath . $fileName)->resize(
						$this->width, $this->height, function($constraint){
						$constraint->aspectRatio();
					})->save($destinationPath . $fileName);

					Image::make($destinationPath . $fileName)->resize(
						$this->thumbWidth, $this->thumbHeight, function($constraint){
						$constraint->aspectRatio();
					})->save($destinationThumbPath . $fileName);

					Image::make($destinationPath . $fileName)->resize(
						$this->loopWidth, $this->loopHeight, function($constraint){
						$constraint->aspectRatio();
					})->save($destinationLoopPath . $fileName);

					$this->article->file_name = $fileName;
					$this->article->file_size = $fileSize;
					$this->article->path = $this->imgDir;
				}
			}


			$this->article->lang = $this->getLang();
			if($this->article->fill($attributes)->save()){
				$category = Category::find($attributes['category']);
				$category->articles()->save($this->article);
			}

			$articleTags = explode(',', $attributes['tag']);

			foreach($articleTags as $articleTag){
				if(!$articleTag){
					continue;
				}

				$tag = Tag::where('name', '=', $articleTag)->first();

				if(!$tag){
					$tag = new Tag();
				}

				$tag->lang = $this->getLang();
				$tag->name = $articleTag;
				//$tag->slug = Str::slug($articleTag);

				$this->article->tags()->save($tag);
			}

			//Event::fire('article.created', $this->article);
			Event::fire('article.creating', $this->article);

			return true;
		}

		throw new ValidationException('Article validation failed', $this->getErrors());
	}

	/**
	 * @param $id
	 * @param $attributes
	 *
	 * @return bool|mixed
	 *
	 * @throws \App\Exceptions\Validation\ValidationException
	 */
	public function update($id, $attributes)
	{
		$this->article = $this->find($id);
		$attributes['is_published'] = isset($attributes['is_published']) ? true : false;
		if ($this->isValid($attributes)) {

			//-------------------------------------------------------
			if (isset($attributes['image'])){
				$file = $attributes['image'];

				$destinationOriginal = "uploads/article/originals/";
				$destinationPath = public_path().$this->imgDir;
				$destinationThumbPath = public_path().$this->thumbDir;
				File::delete($destinationPath.$this->article->file_name);
				File::delete($destinationThumbPath.$this->article->file_name);
				$destinationPath = public_path().$this->imgDir;
				$destinationThumbPath = public_path().$this->thumbDir;


				//dd("PATH: " .$destinationPath,"THUMB PATH: ". $destinationThumbPath, "Original PATH: " .$destinationOriginal);



				$fileName = $file->getClientOriginalName();
				$fileSize = $file->getClientSize();
				$upload_success = $file->move($destinationPath, $fileName);
				if ($upload_success) {
					Image::make($destinationPath.$fileName)->save($destinationOriginal.$fileName);
					Image::make($destinationPath.$fileName)->resize($this->width, $this->height)->save($destinationPath.$fileName);

					Image::make($destinationPath.$fileName)->resize($this->thumbWidth, $this->thumbHeight)->save($destinationThumbPath.$fileName);
//
//					Image::make($destinationPath . $fileName)->resize($this->width, $this->height)->save($destinationPath.$fileName);
//					Image::make($destinationPath . $fileName)->resize($this->thumbWidth, $this->thumbHeight,function ($constraint) { $constraint->upsize(); })->save($destinationThumbPath.$fileName);


//					Image::make($fileName)->resize(
//						$this->width, $this->height,  function ($constraint) {
//						$constraint->aspectRatio();
//					})->save($destinationPath.$fileName);
//					Image::make($destinationPath.$fileName)->resize(
//						$this->thumbWidth, $this->thumbHeight,  function ($constraint) {
//						$constraint->aspectRatio();
//					})->save($destinationThumbPath.$fileName);
					$this->article->lang = $this->getLang();
					$this->article->file_name = $fileName;
					$this->article->file_size = $fileSize;
					$this->article->path = $this->imgDir;
				}
			}
			//-------------------------------------------------------

			//-------------------------------------------------------
			if ($this->article->fill($attributes)->save()) {
				$this->article->resluggify();
				$category = Category::find($attributes['category']);
				$category->articles()->save($this->article);
			}
			$articleTags = explode(',', $attributes['tag']);
			foreach ($articleTags as $articleTag) {
				if (!$articleTag) {
					continue;
				}
				$tag = Tag::where('name', '=', $articleTag)->first();
				if (!$tag) {
					$tag = new Tag();
				}
				$tag->lang = $this->getLang();
				$tag->name = $articleTag;
				//$tag->slug = Str::slug($articleTag);
				$this->article->tags()->save($tag);
			}
			return true;
		}
		throw new ValidationException('Article validation failed', $this->getErrors());
	}

	/**
	 * @param $id
	 *
	 * @return mixed|void
	 */
	public function delete($id)
	{
		$article = $this->article->findOrFail($id);
		$article->tags()->detach();
		$article->delete();
	}

	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function togglePublish($id)
	{
		$article = $this->article->find($id);

		$article->is_published = ($article->is_published) ? false : true;
		$article->save();

		return Response::json(['result' => 'success', 'changed' => ($article->is_published) ? 1 : 0]);
	}

	/**
	 * @param $id
	 *
	 * @return string
	 */
	public function getUrl($id)
	{
		$article = $this->article->findOrFail($id);

		return url('article/' . $id . '/' . $article->slug, $parameters = [], $secure = null);
	}

	/**
	 * Get total article count.
	 *
	 * @param bool $all
	 *
	 * @return mixed
	 */
	protected function totalArticles($all = false)
	{
		if(!$all){
			return $this->article->where('is_published', 1)->where('lang', $this->getLang())->count();
		}

		return $this->article->where('lang', $this->getLang())->count();
	}
}
