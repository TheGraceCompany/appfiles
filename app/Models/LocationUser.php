<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationUser extends Model
{
    protected $table = 'location_user';
    protected $fillable = ['location_id', 'user_id'];

    /**
     * @method location
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsToMany(Location::class);
    }

    /**
     * @method product
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
