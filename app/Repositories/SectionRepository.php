<?php

/*
 * @author Phillip Madsen
 */

namespace App\Repositories;

use App\Models\Section;

class SectionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'meta_description',
        'slug',
        'lang',
    ];

    /**
     * Configure the Model.
     **/
    public function model()
    {
        return Section::class;
    }
}
