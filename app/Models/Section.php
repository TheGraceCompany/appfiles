<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    public $table = 'sections';
    protected $dates = ['deleted_at'];
    public $fillable = [
        'name',
        'meta_description',
        'slug',
        'lang',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name'             => 'string',
        'meta_description' => 'string',
        'slug'             => 'string',
        'lang'             => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
