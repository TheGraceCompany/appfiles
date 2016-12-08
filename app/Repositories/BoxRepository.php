<?php

namespace App\Repositories;

use App\Models\Box;
use App\Repositories\BaseRepository;

class BoxRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nickname'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Box::class;
    }
}
