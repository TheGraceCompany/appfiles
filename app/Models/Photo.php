<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Photo.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class Photo extends Model
{
    public $table = 'photos';
    public $timestamps = false;

    /**
     * @method slider
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function slider()
    {
        return $this->morphTo('App\Models\Slider', 'relationship');
    }

    /**
     * @method photo_gallery
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function photo_gallery()
    {
        return $this->morphTo('App\Models\PhotoGallery', 'relationship');
    }

    /**
     * Relationship with the product model.
     *
     * @author    Phillip Madsen
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(App\Models\Product::class);
    }
}
