<?php

/*
 * @author Phillip Madsen
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductVariant.
 */
class ProductVariant extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];
    protected $table = 'product_variants';
}
