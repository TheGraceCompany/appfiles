<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRequirement extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'product_requirements';

    /**
     * @method product
     * @public
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
