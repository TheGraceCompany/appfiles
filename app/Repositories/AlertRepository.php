<?php

/*
 * @author Phillip Madsen
 */

namespace App\Repositories;

use App\Models\Alert;

class AlertRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'alert_title',
        'alert_message',
        'alerticon',
        'alertstyle',
        'alerttype',
    ];

    /**
     * Configure the Model.
     **/
    public function model()
    {
        return Alert::class;
    }
}
