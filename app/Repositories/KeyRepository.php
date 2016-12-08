<?php

namespace App\Repositories;

use App\Models\Key;
use App\Repositories\BaseRepository;

class KeyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'date_of_purchase'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Key::class;
    }
}
