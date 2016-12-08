<?php

namespace App\Repositories\Page;

use App\Exceptions\Validation\ValidationException;
use App\Models\Page;
use App\Repositories\CrudableInterface as CrudableInterface;
use App\Repositories\RepositoryAbstract;
use Config;
use File;
use Image;
use Response;

/**
 * Class PageRepository.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class PageRepository extends RepositoryAbstract implements PageInterface, CrudableInterface
{
    /**
     * @var
     */
    protected $perPage;
    protected $width;
    protected $height;
    protected $thumbWidth;
    protected $thumbHeight;
    protected $imgDir;
    protected $thumbDir;
    protected $loopDir;
    protected $loopWidth;
    protected $loopHeight;
    protected $page;

    protected static $rules = [
        'title'   => 'required|min:3',
        'content' => 'required|min:5', ];

    /**
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $config = Config::get('grace');
        $this->perPage = $config['per_page'];
        $this->width = $config['modules']['page']['image_size']['width'];
        $this->height = $config['modules']['page']['image_size']['height'];
        $this->thumbWidth = $config['modules']['page']['thumb_size']['width'];
        $this->thumbHeight = $config['modules']['page']['thumb_size']['height'];
        $this->loopWidth = $config['modules']['page']['loop_size']['width'];
        $this->loopHeight = $config['modules']['page']['loop_size']['height'];
        $this->imgDir = $config['modules']['page']['image_dir'];
        $this->thumbDir = $config['modules']['page']['thumb_dir'];
        $this->loopDir = $config['modules']['page']['loop_dir'];
        $this->page = $page;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->page->where('lang', $this->getLang())->get();
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug, $isPublished = false)
    {
        if ($isPublished === true) {
            return $this->page->where('slug', $slug)->where('is_published', true)->first();
        }

        return $this->page->where('slug', $slug)->first();
    }

    /**
     * @return mixed
     */
    public function lists()
    {
        return $this->page->where('lang', $this->getLang())->lists('title', 'id');
    }

    /**
     * Get paginated pages.
     *
     * @param int  $page  Number of pages per page
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

        $query = $this->page->orderBy('created_at', 'DESC')->where('lang', $this->getLang());

        if (!$all) {
            $query->where('is_published', 1);
        }

        $pages = $query->skip($limit * ($page - 1))->take($limit)->get();

        $result->totalItems = $this->totalPages($all);
        $result->items = $pages->all();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->page->find($id);
    }

    /**
     * @param $attributes
     *
     * @throws \App\Exceptions\Validation\ValidationException
     *
     * @return bool|mixed
     */
    public function create($attributes)
    {
        $attributes['is_published'] = isset($attributes['is_published']) ? true : false;

        //--------------------------------------------------------

        $file = null;
        if (isset($attributes['image'])) {
            $file = $attributes['image'];
        }
        if ($file) {
            $destinationPath = public_path().$this->imgDir;
            $destinationThumbPath = $destinationPath.$this->thumbDir;
            $destinationLoopPath = $destinationPath.$this->loopDir;

            File::exists($destinationPath) or File::makeDirectory($destinationPath);
            File::exists($destinationThumbPath) or File::makeDirectory($destinationThumbPath);
            File::exists($destinationLoopPath) or File::makeDirectory($destinationLoopPath);

            File::delete($destinationPath.$this->page->filename);
            File::delete($destinationThumbPath.$this->page->filename);
            File::delete($destinationLoopPath.$this->page->filename);

            $destinationPath = $destinationPath;
            $destinationThumbPath = $destinationPath.$destinationThumbPath;
            $destinationLoopPath = $destinationPath.$destinationLoopPath;

            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getClientSize();
            $upload_success = $file->move($destinationPath, $fileName);
            if ($upload_success) {
                Image::make($destinationPath.$fileName)->resize(
                    $this->width, $this->height, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath.$fileName);

                Image::make($destinationPath.$fileName)->resize(
                    $this->thumbWidth, $this->thumbHeight, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationThumbPath.$fileName);

                Image::make($destinationPath.$fileName)->resize(
                    $this->loopWidth, $this->loopHeight, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationLoopPath.$fileName);

                $this->page->file_name = $fileName;
                $this->page->file_size = $fileSize;
                $this->page->path = $this->imgDir;
            }
        }

        if ($this->isValid($attributes)) {
            $this->page->lang = $this->getLang();
            $this->page->fill($attributes)->save();

            return true;
        }

        throw new ValidationException('Page validation failed', $this->getErrors());
    }

    /**
     * @param $id
     * @param $attributes
     *
     * @throws \App\Exceptions\Validation\ValidationException
     *
     * @return bool|mixed
     */
    public function update($id, $attributes)
    {
        $attributes['is_published'] = isset($attributes['is_published']) ? true : false;

        if (isset($attributes['image'])) {
            $file = $attributes['image'];

            $destinationPath = public_path().$this->imgDir;
            $destinationThumbPath = $destinationPath.$this->thumbDir;
            $destinationLoopPath = $destinationPath.$this->loopDir;

            File::exists($destinationPath) or File::makeDirectory($destinationPath);
            File::exists($destinationThumbPath) or File::makeDirectory($destinationThumbPath);
            File::exists($destinationLoopPath) or File::makeDirectory($destinationLoopPath);

            File::delete($destinationPath.$this->page->filename);
            File::delete($destinationThumbPath.$this->page->filename);
            File::delete($destinationLoopPath.$this->page->filename);

            $destinationPath = $destinationPath;
            $destinationThumbPath = $destinationThumbPath;
            $destinationLoopPath = $destinationLoopPath;

            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getClientSize();
            $upload_success = $file->move($destinationPath, $fileName);
            if ($upload_success) {
                Image::make($destinationPath.$fileName)->resize(
                    $this->width, $this->height, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath.$fileName);
                Image::make($destinationPath.$fileName)->resize(
                    $this->thumbWidth, $this->thumbHeight, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationThumbPath.$fileName);
                Image::make($destinationPath.$fileName)->resize(
                    $this->loopWidth, $this->loopHeight, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationLoopPath.$fileName);

                $this->page->file_name = $fileName;
                $this->page->file_size = $fileSize;
                $this->page->path = $this->imgDir;
            }
        }

        $this->page = $this->find($id);

        if ($this->isValid($attributes)) {
            $this->page->resluggify();
            $this->page->fill($attributes)->save();

            return true;
        }

        throw new ValidationException('Category validation failed', $this->getErrors());
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function delete($id)
    {
        $this->page->findOrFail($id)->delete();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function togglePublish($id)
    {
        $page = $this->page->find($id);
        $page->is_published = ($page->is_published) ? false : true;
        $page->save();

        return Response::json(['result' => 'success', 'changed' => ($page->is_published) ? 1 : 0]);
    }

    /**
     * Get total page count.
     *
     * @param bool $all
     *
     * @return mixed
     */
    protected function totalPages($all = false)
    {
        if (!$all) {
            return $this->page->where('is_published', 1)->where('lang', $this->getLang())->count();
        }

        return $this->page->where('lang', $this->getLang())->count();
    }
}
