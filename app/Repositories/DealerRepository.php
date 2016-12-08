<?php

namespace App\Repositories;

use App\Models\Dealer;
use App\Repositories\BaseRepository;

class DealerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'dealer',
        'contact_person',
        'mobile',
        'phone',
        'hours_opening_mf',
        'hours_closing_mf',
        'hours_opening_sat',
        'hours_closing_sat',
        'hours_opening_sun',
        'hours_closing_sun',
        'company_phone',
        'toll_free',
        'public_email',
        'support_email'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Dealer::class;
    }
}
