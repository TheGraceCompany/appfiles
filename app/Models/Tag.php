<?php



namespace App\Models;

use App\Interfaces\ModelInterface as ModelInterface;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class Tag extends Model implements ModelInterface, SluggableInterface
{
    use SluggableTrait;

    public $table = 'tags';
    protected $appends = ['url'];

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];

    /**
     * @method articles
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany('App\Models\Article', 'articles_tags');
    }

    /**
     * @method setUrlAttribute
     * @public
     *
     * @param {any} $value
     *
     * @return mixed|void
     */
    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = $value;
    }

    /**
     * @method getUrlAttribute
     * @public
     *
     * @return mixed|string {any}
     */
    public function getUrlAttribute()
    {
        return '/tag/'.$this->attributes['slug'];
    }
}
