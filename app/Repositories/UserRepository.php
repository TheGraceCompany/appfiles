<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'isAdmin',
        'slug'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }
}
