<?php

/*
 * @author Phillip Madsen
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = ['id'];

    /**
     * @method user
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(App\Models\User::class);
    }

    /**
     * @method products
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(App\Models\Product::class);
    }

    /**
     * @method coupon
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(App\Models\Coupon::class);
    }
}
