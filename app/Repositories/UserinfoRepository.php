<?php

/*
 * @author Phillip Madsen
 */

namespace App\Repositories;

use App\Models\Userinfo;

class UserinfoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'photo',
        'about_me',
        'website',
        'company',
        'gender',
        'phone',
        'mobile',
        'work',
        'other',
        'is_published',
        'is_active',
        'dob',
        'skypeid',
        'githubid',
        'twitter_username',
        'instagram_username',
        'facebook_username',
        'facebook_url',
        'linked_in_url',
        'google_plus_url',
        'slug',
        'display_name',
    ];

    /**
     * Configure the Model.
     **/
    public function model()
    {
        return Userinfo::class;
    }
}
