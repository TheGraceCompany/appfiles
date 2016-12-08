<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Slider.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class Slider extends Model
{
    public $table = 'sliders';

    /**
     * @method images
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany('App\Models\Photo', 'relationship', 'type');
    }
}
