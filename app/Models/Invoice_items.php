<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice_items extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
