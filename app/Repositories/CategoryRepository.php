<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'section_id',
        'meta_description',
        'banner',
        'slug',
        'lang',
    ];

    /**
     * Configure the Model.
     **/
    public function model()
    {
        return Category::class;
    }
}
