<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    public $table = 'locations';
    protected $dates = ['deleted_at'];
    public $fillable = [
        'location_type',
        'first_name',
        'last_name',
        'company',
        'email',
        'phone',
        'address2',
        'nickname',
        'address',
        'street',
        'street_additional',
        'city',
        'state',
        'country',
        'zipcode',
        'latitude',
        'longitude',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'location_type'     => 'string',
        'nickname'          => 'string',
        'address'           => 'string',
        'street'            => 'string',
        'street_additional' => 'string',
        'city'              => 'string',
        'state'             => 'string',
        'country'           => 'string',
        'zipcode'           => 'string',
        'latitude'          => 'string',
        'longitude'         => 'string',
        'status'            => 'boolean',
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
     * Relationship with the dealers model.
     *
     * @author    Phillip Madsen
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Dealers()
    {
        return $this->belongsToMany(Dealer::class);
    }

    public function users()
    {
        return $this->hasOne(User::class);
    }
}
