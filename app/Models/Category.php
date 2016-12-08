<?php



namespace App\Models;

use App\Interfaces\ModelInterface as ModelInterface;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class Category extends Model implements ModelInterface, SluggableInterface
{
    use SluggableTrait;
    use SoftDeletes;

    public $table = 'categories';
    public $timestamps = false;

    public $fillable = [
        'title',
        'section_id',
        'meta_description',
        'banner',
        'slug',
        'lang',
    ];

    protected $appends = ['url'];

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    protected $casts = [
        'title'            => 'string',
        'section_id'       => 'integer',
        'meta_description' => 'string',
        'banner'           => 'string',
        'slug'             => 'string',
        'lang'             => 'string',
    ];

    public static $rules = [
        ];

    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = $value;
    }

    public function getUrlAttribute()
    {
        return 'category/'.$this->attributes['slug'];
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }

    public function subcats()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
