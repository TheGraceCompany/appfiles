<?php



namespace App\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *      definition="Product",
 *      required={slug, name},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="slug",
 *          description="slug",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="ispromo",
 *          description="ispromo",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="is_published",
 *          description="is_published",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="availability",
 *          description="availability",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="manufacturer",
 *          description="manufacturer",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="office_status",
 *          description="office_status",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="model",
 *          description="model",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="sku",
 *          description="sku",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="upc",
 *          description="upc",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="subtitle",
 *          description="subtitle",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="details",
 *          description="details",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="category",
 *          description="category",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="meta_title",
 *          description="meta_title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="meta_description",
 *          description="meta_description",
 *          type="string"
 *      ),
 *  *      @SWG\Property(
 *          property="meta_keywords",
 *          description="meta_keywords",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="price",
 *          description="price",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="sale_price",
 *          description="sale_price",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="quantity",
 *          description="quantity",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="tracking",
 *          description="tracking",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="datalayer",
 *          description="datalayer",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="pubished_at",
 *          description="pubished_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Product extends Model implements SluggableInterface
{
    use SluggableTrait;

    /**
     * @var string
     */
    protected $table = 'products';
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * @var array
     */
    protected $dates = ['pubished_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'id', 'slug', 'ispromo', 'is_published', 'name', 'subtitle', 'details', 'description', 'status', 'office_status', 'availability', 'thumbnail', 'thumbnail2', 'thumbnail3', 'photo_album', 'pubished_at', 'video_url', 'lang', 'manufacturer', 'category_id', 'hasWarranty', 'isDev', 'features_heading', 'price_heading', 'review_heading', 'additional_heading', 'waranty_heading', 'support_heading', 'docs_heading', 'meta_title', 'meta_keywords', 'meta_description', 'facebook_title', 'google_plus_title', 'twitter_title', 'price', 'quantity', 'model', 'sku', 'upc', 'tracking', 'datalayer', 'filter_class',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @var array
     */
    protected $casts = [
        'slug'               => 'string',
        'ispromo'            => 'boolean',
        'is_published'       => 'boolean',
        'hasWarranty'        => 'boolean',
        'isDev'              => 'boolean',
        'name'               => 'string',
        'subtitle'           => 'string',
        'details'            => 'text',
        'description'        => 'text',
        'status'             => 'string',
        'office_status'      => 'string',
        'availability'       => 'string',
        'thumbnail'          => 'string',
        'thumbnail2'         => 'string',
        'thumbnail3'         => 'string',
        'photo_album'        => 'string',
        'video_url'          => 'string',
        'pubished_at'        => 'date',
        'lang'               => 'string',
        'alerttype'          => 'string',
        'alerticon'          => 'string',
        'alertstyle'         => 'string',
        'alert_title'        => 'string',
        'alert_message'      => 'text',
        'manufacturer'       => 'string',
        'category_id'        => 'integer',
        'features_heading'   => 'string',
        'price_heading'      => 'string',
        'review_heading'     => 'string',
        'additional_heading' => 'string',
        'waranty_heading'    => 'string',
        'support_heading'    => 'string',
        'docs_heading'       => 'string',
        'meta_title'         => 'string',
        'meta_description'   => 'string',
        'meta_keywords'      => 'string',
        'facebook_title'     => 'string',
        'google_plus_title'  => 'string',
        'twitter_title'      => 'string',
        'price'              => 'string',
        'quantity'           => 'string',
        'model'              => 'string',
        'sku'                => 'string',
        'upc'                => 'string',
        'tracking'           => 'string',
        'datalayer'          => 'string',
        'filter_class'       => 'string',

    ];

    public function getPriceAttribute($price)
    {
        return number_format($price, 2, '.', '');
    }

    /**
     * Returns the formatted subtotal.
     * Subtotal is price for whole CartItem without TAX.
     *
     * @return string
     */
    public function getSubtotalAttribute($subtotal)
    {
        return '$'.number_format($subtotal, 2, '.', '');
    }

    /**
     * Returns the formatted total.
     * Total is price for whole CartItem with TAX.
     *
     * @return string
     */
    public function getTotalAttribute($total)
    {
        return '$'.number_format($total, 2, '.', '');
    }

    /**
     * Set the quantity for this cart item.
     *
     * @param int|float $quantity
     */
    public function setQuantity($quantity)
    {
        if (empty($quantity) || !is_numeric($quantity)) {
            throw new \InvalidArgumentException('Please supply a valid quantity.');
        }

        $this->quantity = $quantity;
    }

    public function getProductCategoryAttribute()
    {
        return $this->category->lists('id');
    }

    /**
     * @var array
     */
    public static $rules = [

        'name' => 'required',
        'slug' => 'required',
    ];

    /**
     * @var array
     */
    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];

    /**
     * @method categories
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    /**
     * @method orders
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    /**
     * @method carts
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }

    /**
     * @method photos
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(AlbumPhoto::class);
    }

    /**
     * @method options
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }

     /**
      * @method category
      * @public
      *
      * @return \Illuminate\Database\Eloquent\Relations\HasOne
      */
    // public function category()
    // {
    //     return $this->hasOne(Category::class, 'id', 'category_id', 'title');
    // }

     public function category()
     {
         $categories = $this->hasOne(Category::class, 'id', 'category_id', 'title')->select(['id', 'title']);

         return $categories;
     }

    /**
     * @method productVariants
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    /**
     * @method productRequirements
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productRequirements()
    {
        return $this->hasMany(ProductRequirement::class);
    }

    /**
     * @method productFeatures
     * @public
     *
     * @return \Illuminate\Database\Eloquent\RelationsHasMany
     */
    public function productFeatures()
    {
        return $this->hasMany(ProductFeature::class);
    }

    /**
     * @method variants
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * @method requirements
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requirements()
    {
        return $this->hasMany(ProductRequirement::class);
    }

    /**
     * @method features
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyP
     */
    public function features()
    {
        return $this->hasMany(ProductFeature::class);
    }

    /**
     * @return mixed
     */
    public function keys()
    {
        return $this->hasMany(Key::class);
    }

    /**
     * @method model
     * @public
     *
     * @return
     */
    public function model()
    {
        return self::class;
    }
}
