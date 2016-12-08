<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dealer extends Model
{
    use SoftDeletes;
    public $table = 'dealers';

    protected $dates = ['pubished_at', 'deleted_at'];

    public $fillable = [
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
        'support_email',
        'location_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                => 'string',
        'dealer'            => 'string',
        'contact_person'    => 'string',
        'mobile'            => 'string',
        'phone'             => 'string',
        'hours_opening_mf'  => 'string',
        'hours_closing_mf'  => 'string',
        'hours_opening_sat' => 'string',
        'hours_closing_sat' => 'string',
        'hours_opening_sun' => 'string',
        'hours_closing_sun' => 'string',
        'company_phone'     => 'string',
        'toll_free'         => 'string',
        'public_email'      => 'string',
        'support_email'     => 'string',
        'location_id'       => 'integer',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function locations()
    {
        return $this->hasMany(\App\Models\Location::class, 'location_id', 'id');
    }
}
