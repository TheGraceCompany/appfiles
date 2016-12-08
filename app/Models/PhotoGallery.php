<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use App\Interfaces\ModelInterface as ModelInterface;

/**
 * Class PhotoGallery.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class PhotoGallery extends BaseModel implements ModelInterface, SluggableInterface
{
    use SluggableTrait;

    public $table = 'photo_galleries';
    public $fillable = ['title', 'content', 'is_published'];
    protected $appends = ['url'];

    protected $sluggable = array(
        'build_from' => 'title',
        'save_to' => 'slug',
    );

    /**
      * @method photos
      * @public
      * @return \Illuminate\Database\Eloquent\Relations\MorphMany
      */
    public function photos()
    {
        return $this->morphMany('App\Models\Photo', 'relationship', 'type');
    }

    /**
      * @method setUrlAttribute
      * @public
      * @param {any} $value
      */
    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = $value;
    }

    /**
      * @method getUrlAttribute
      * @public
      *
      */
    public function getUrlAttribute()
    {
        return 'photo-gallery/'.$this->attributes['slug'];
    }
}
