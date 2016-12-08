<?php

/*
 * @author Phillip Madsen
 */

namespace App\Repositories\Faq;

use App\Exceptions\Validation\ValidationException;
use App\Models\Faq;
use App\Repositories\CrudableInterface;
use App\Repositories\RepositoryAbstract;
use Config;

/**
 * Class FaqRepository.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class FaqRepository extends RepositoryAbstract implements FaqInterface, CrudableInterface
{
    protected $perPage;
    protected $width;
    protected $height;
    protected $imgDir;
    protected $faq;

    protected static $rules = [
        'question' => 'required',
        'answer'   => 'required',
    ];

    /**
     * @param Faq $faq
     */
    public function __construct(Faq $faq)
    {
        $this->faq = $faq;
        $config = Config::get('grace');
        $this->width = $config['modules']['faq']['image_size']['width'];
        $this->height = $config['modules']['faq']['image_size']['height'];
        $this->imgDir = $config['modules']['faq']['image_dir'];
        $this->perPage = $config['per_page'];
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->faq->where('lang', $this->getLang())->get();
    }

    public function lists()
    {
        return $this->faq->get()->where('lang', $this->getLang())->lists('title', 'id');
    }

    /**
     * Get paginated faqs.
     *
     * @param int  $page  Number of faqs per page
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

        $query = $this->faq->orderBy('created_at', 'DESC')->where('lang', $this->getLang());

        $faqs = $query->skip($limit * ($page - 1))->take($limit)->get();

        $result->totalItems = $this->totalFaqs();
        $result->items = $faqs->all();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->faq->findOrFail($id);
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
        $file = null;
        if (isset($attributes['thumbnail'])) {
            $file = $attributes['thumbnail'];
        }

        $destinationPath = public_path().$this->imgDir;
        File::exists($destinationPath) or File::makeDirectory($destinationPath);
        File::delete($destinationPath.$this->product->filename);
        $destinationPath = $destinationPath;

        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getClientSize();

        $upload_success = $file->move($destinationPath, $fileName);

        if ($upload_success) {
            $upload_success = $file->move($destinationPath, $fileName);

            if ($upload_success) {
                Image::make($destinationPath.$fileName)->resize(
                    $this->width, $this->height, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath.$fileName);

                //  $this->faq->file_name = $fileName;
                //  $this->faq->file_size = $fileSize;
                //  $this->faq->path = $this->imgDir;
            }

           // $product['thumbnail'] = '/' . $destinationPath.$fileName;
            $file = $destinationPath.$fileName;
        }

        if ($this->isValid($attributes)) {
            $this->faq->lang = $this->getLang();
            $this->faq->fill($attributes)->save();

            return true;
        }

        throw new ValidationException('Faq validation failed', $this->getErrors());
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
        $this->faq = $this->find($id);

        if ($this->isValid($attributes)) {
            $this->faq->fill($attributes)->save();

            return true;
        }

        throw new ValidationException('Faq validation failed', $this->getErrors());
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function delete($id)
    {
        $this->faq->find($id)->delete();
    }

    /**
     * Get total faq count.
     *
     * @param bool $all
     *
     * @return mixed
     */
    protected function totalFaqs()
    {
        return $this->faq->where('lang', $this->getLang())->count();
    }
}
