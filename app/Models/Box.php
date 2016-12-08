<?php

/*
 * @author Phillip Madsen
 */

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Box extends Model
{
    use SoftDeletes;

    public $table = 'boxes';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'nickname',
        'outer_length',
        'outer_width',
        'inner_height',
        'inner_length',
        'inner_width',
        'outer_height',
        'box_weight',
        'max_weight',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nickname'     => 'string',
        'outer_length' => 'string',
        'outer_width'  => 'string',
        'inner_height' => 'string',
        'inner_length' => 'string',
        'inner_width'  => 'string',
        'outer_height' => 'string',
        'box_weight'   => 'string',
        'max_weight'   => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'nickname'     => 'required',
        'outer_length' => 'required',
        'outer_width'  => 'required',
        'inner_height' => 'required',
        'inner_length' => 'required',
        'inner_width'  => 'required',
        'outer_height' => 'required',
        'box_weight'   => 'required',
        'max_weight'   => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function shippingmethods()
    {
        return $this->belongsToMany(\App\Models\Shippingmethod::class, 'boxes_shippingmethods', 'box_id', 'shippingmethod_id');
    }
}
