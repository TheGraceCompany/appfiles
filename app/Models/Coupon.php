<?php

/*
 * @author Phillip Madsen
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';
    protected $guarded = ['id'];

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
}
