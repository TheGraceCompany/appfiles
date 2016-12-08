<?php

/*
 * @author Phillip Madsen
 */

namespace App\Models;

use App\Interfaces\ModelInterface as ModelInterface;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Project.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class Project extends Model implements ModelInterface, SluggableInterface
{
    use SluggableTrait;

    public $table = 'projects';
    protected $fillable = ['title', 'description'];

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = $value;
    }

    public function getUrlAttribute()
    {
        return 'project/'.$this->attributes['slug'];
    }
}
