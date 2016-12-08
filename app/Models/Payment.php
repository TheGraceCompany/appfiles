<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $fillable = ['stripe_publishable_key', 'stripe_secret_key', 'paypal_client_id', 'paypal_secret'];
}
