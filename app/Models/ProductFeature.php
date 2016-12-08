<?php

/*
 * @author Phillip Madsen
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductFeature.
 */
class ProductFeature extends Model
{
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'product_features';

    /**
     * @var array
     */
    public $fillable = [
        'feature_name',
        'useicon',
        'icon',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'feature_name' => 'string',
        'useicon'      => 'boolean',
        'icon'         => 'string',
    ];
}
