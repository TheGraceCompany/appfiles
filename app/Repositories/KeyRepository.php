<?php

/*
 * @author Phillip Madsen
 */

namespace App\Repositories;

use App\Models\Key;

class KeyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'date_of_purchase',
    ];

    /**
     * Configure the Model.
     **/
    public function model()
    {
        return Key::class;
    }
}
