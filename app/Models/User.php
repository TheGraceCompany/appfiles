<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser {

    protected $table = 'users';
    protected $guarded = ['id'];
    protected $fillable = ['username', 'email', 'password', 'isAdmin', 'last_login', 'first_name', 'last_name', 'slug', 'uuid', 'referral_id', 'is_online', 'referred_by'];
    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'password' => 'string',
        'permissions' => 'string',
        'username' => 'string',
        'email' => 'string',
        'isAdmin' => 'boolean',
        'slug' => 'string',
        'uuid' => 'string',
        'referral_id' => 'integer',
        'is_online' => 'string',
        'referred_by' => 'integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cart() {
        return $this->hasMany(Cart::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages() {
        return $this->hasMany(Message::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders() {
        return $this->hasMany(Order::class);
    }

    /**
     * @method userInfo
     * @public
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userInfo() {
        return $this->hasOne(UserInfo::class);
    }

    /**
     * @method userInfo
     * @public
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location() {
        return $this->belongsToMany(Location::class, 'location_user', 'user_id', 'location_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products() {
        return $this->hasMany(Product::class);
    }


	/**
	 * @method locations
	 * @public
	 *@return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function locations()
	{
		return $this->hasMany(locations::class);
	}

}
