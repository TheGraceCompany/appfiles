<?php



namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Key extends Model
{
    use SoftDeletes;

    public $table = 'keys';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'order_id',
        'user_id',
        'product_id',
        'date_of_purchase',
        'warranty_key',
        'license_key',
        'requested_key',
        'generated_key',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_id'         => 'integer',
        'user_id'          => 'integer',
        'product_id'       => 'integer',
        'date_of_purchase' => 'datetime',
        'warranty_key'     => 'string',
        'license_key'      => 'string',
        'requested_key'    => 'string',
        'generated_key'    => 'string',
         'status'          => 'boolean',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * todo add status to key table and uncomment this function.
     */
    // public function scopeActive($query)
    // {
    //     return $query->where('status', 1);
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class, 'order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }

    //     public function software()
    // {
    //     return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    // }
}
