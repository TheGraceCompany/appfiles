<?php

/*
 * @author Phillip Madsen
 */

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shippingmethod extends Model
{
    use SoftDeletes;

    public $table = 'shippingmethods';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'access_key',
        'ups_username',
        'ups_password',
        'method_title',
        'account_number',
        'delivery_confirmation',
        'dc_per_package_price',
        'pickup_type',
        'price_adjustment_flat',
        'price_adjustment_percent',
        'flag_residential',
        'add_insurance',
        'negotiated_rates',
        'weight',
        'measurement',
        'box_id',
        'product_id',
        'location_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'access_key'               => 'string',
        'ups_username'             => 'string',
        'ups_password'             => 'string',
        'method_title'             => 'string',
        'account_number'           => 'string',
        'delivery_confirmation'    => 'string',
        'dc_per_package_price'     => 'string',
        'pickup_type'              => 'string',
        'price_adjustment_flat'    => 'string',
        'price_adjustment_percent' => 'string',
        'flag_residential'         => 'boolean',
        'add_insurance'            => 'boolean',
        'negotiated_rates'         => 'boolean',
        'weight'                   => 'integer',
        'measurement'              => 'integer',
        'box_id'                   => 'integer',
        'product_id'               => 'integer',
        'location_id'              => 'integer',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function box()
    {
        return $this->belongsTo(\App\Models\Box::class, 'box_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function location()
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function products()
    {
        return $this->belongsToMany(\App\Models\Product::class, 'products_shippingmethods', 'product_id', 'shippingmethod_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function locations()
    {
        return $this->belongsToMany(\App\Models\Location::class, 'locations_shippingmethods', 'location_id', 'shippingmethod_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function boxes()
    {
        return $this->belongsToMany(\App\Models\Box::class, 'boxes_shippingmethods', 'box_id', 'shippingmethod_id');
    }
}
