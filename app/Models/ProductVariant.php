<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class ProductVariant
 * @package App\Models
 */
class ProductVariant extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded  = ['id'];
    protected $table = 'product_variants';
}
