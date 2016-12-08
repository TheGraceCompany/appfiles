<?php

namespace App\Repositories;

use App\Models\Box;

class BoxRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nickname',
    ];

    /**
     * Configure the Model.
     **/
    public function model()
    {
        return Box::class;
    }
}
