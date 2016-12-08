<?php

namespace App\Repositories\Category;

use App\Exceptions\Validation\ValidationException;
use App\Models\Category;
use App\Models\Section;
use App\Repositories\CrudableInterface;
use App\Repositories\RepositoryAbstract;
use Config;
use Event;
use File;
use Image;

/**
 * Class CategoryRepository.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class CategoryRepository extends RepositoryAbstract implements CategoryInterface, CrudableInterface
{
    /**
     * @var mixed
     */
    protected $width;

    /**
     * @var mixed
     */
    protected $height;

    /**
     * @var mixed
     */
    protected $imgDir;

    /**
     * @var mixed
     */
    protected $perPage;

    /**
     * @var mixed
     */
    protected $category;

    /**
     * @var array
     */
    protected static $rules = [
        'title' => 'required|min:3|unique:categories',
    ];

    /**
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;

        $config = Config::get('grace');
        $this->perPage = $config['per_page'];
        $this->width = $config['modules']['category']['image_size']['width'];
        $this->height = $config['modules']['category']['image_size']['height'];
        $this->imgDir = $config['modules']['category']['image_dir'];
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->category->where('lang', $this->getLang())->get();
    }

    /**
     * @param $page
     * @param $limit
     * @param $all
     *
     * @return mixed
     */
    public function paginate($page = 1, $limit = 10, $all = false)
    {
        $result = new \StdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = [];

        $query = $this->category->orderBy('title');

        $categories = $query->skip($limit * ($page - 1))->take($limit)->where('lang', $this->getLang())->get();

        $result->totalItems = $this->totalCategories();
        $result->items = $categories->all();

        return $result;
    }

    /**
     * @return mixed
     */
    public function lists()
    {
        return $this->category->where('lang', $this->getLang())->lists('title', 'id');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->category->findOrFail($id);
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getArticlesBySlug($slug)
    {
        return $this->category->where('slug', $slug)->where('lang', $this->getLang())->first()->articles()->paginate($this->perPage);
    }

    /**
     * @TODO CHECK FUNCTIONALITY OF NEW UPLOADER AND SAVING OF NEW FIELDS
     */
    public function create($attributes)
    {
        if ($this->isValid($attributes)) {
            $file = null;
            if (isset($attributes['file'])) {
                $file = $attributes['file'];
            }
            if ($file) {
                $destinationPath = public_path().$this->imgDir;
                $fileName = $file->getClientOriginalName();
                $fileSize = $file->getClientSize();

                $upload_success = $file->move($destinationPath, $fileName);

                if ($upload_success) {
                    Image::make($destinationPath.$fileName)
                            ->resize($this->width, $this->height, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($destinationPath.$fileName);

                    $this->category->banner = $fileName;
                }
            }

            $this->category->lang = $this->getLang();
            // $this->category->fill($attributes)->save()

            if ($this->category->fill($attributes)->save()) {
                $section = Section::find($attributes['section_id']);
                $section->categories()->save($this->category);
            }

            return true;

            //Event::fire('category.creating', $this->category);
        }

        throw new ValidationException('Category validation failed', $this->getErrors());
    }

    /**
     * @TODO ADD UPLOAD AND NEW VALIDATION TO UPDATE LIKE WAS ADDED TO STORE:
     */
    public function update($id, $attributes)
    {
        $rules = ['title' => 'required|min:3|unique:categories,title,'.$id];
        $this->category = $this->find($id);

        if ($this->isValid($attributes, $rules)) {
            $file = null;
            if (isset($attributes['file'])) {
                $file = $attributes['file'];
            }
            if ($file) {
                $destinationPath = public_path().$this->imgDir;
                $fileName = $file->getClientOriginalName();
                $fileSize = $file->getClientSize();

                $upload_success = $file->move($destinationPath, $fileName);

                if ($upload_success) {
                    Image::make($destinationPath.$fileName)
                            ->resize($this->width, $this->height, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($destinationPath.$fileName);

                    // delete old image
                    File::delete($destinationPath.$this->category->banner);

                    $this->category->banner = $fileName;
                }
            }
            $this->category->resluggify();
            $this->category->fill($attributes)->save();

            return true;
        }

        throw new ValidationException('Category validation failed', $this->getErrors());
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->category = $this->category->find($id);
        $this->category->articles()->delete($id);
        $this->category->delete();
    }

    /**
     * @return mixed
     */
    protected function totalCategories()
    {
        return $this->category->where('lang', $this->getLang())->count();
    }
}
