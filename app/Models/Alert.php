<?php



namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alert extends Model
{
    use SoftDeletes;

    public $table = 'alerts';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'alert_title',
        'alert_message',
        'alerticon',
        'alertstyle',
        'alerttype',
        'order_id',
        'user_id',
        'product_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'alert_title'   => 'string',
        'alert_message' => 'string',
        'alerticon'     => 'string',
        'alertstyle'    => 'string',
        'alerttype'     => 'string',
        'order_id'      => 'integer',
        'user_id'       => 'integer',
        'product_id'    => 'integer',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

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
}
