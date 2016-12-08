<?php



namespace app;

use Illuminate\Database\Eloquent\Model;

class EcomPage extends Model
{
    protected $table = 'ecom_pages';
    protected $fillable = ['page_title', 'page_name', 'page_source'];
}
