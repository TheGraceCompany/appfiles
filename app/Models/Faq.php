<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Faq.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class Faq extends Model
{
    public $table = 'faqs';
<<<<<<< HEAD
<<<<<<< HEAD

	public $fillable = [
		'question',
		'answer',
		'is_published',
		'has_product_link',
		'product_link_nofollow',
		'slug',
		'meta_title',
		'meta_description',
		'path',
		'file_name',
		'file_size',
		'answered_by',
		'asked_by',
		'order',
		'link_to_product_title',
		'link_to_product',
		'lang',
		'filter_class',
		'datalayer',
		'tracking',
		'deleted_at'
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'question' => 'string',
		'answer' => 'string',
		'is_published' => 'boolean',
		'has_product_link' => 'boolean',
		'product_link_nofollow' => 'boolean',
		'slug' => 'string',
		'meta_title' => 'string',
		'path' => 'string',
		'file_name' => 'string',
		'file_size' => 'integer',
		'answered_by' => 'string',
		'asked_by' => 'string',
		'order' => 'integer',
		'link_to_product_title' => 'string',
		'link_to_product' => 'string',
		'lang' => 'string',
		'filter_class' => 'string',
		'datalayer' => 'string',
		'tracking' => 'string'
	];



	public function user() {
	  return $this->belongs_to(User::class)->select(array('id', 'username', 'first_name', 'last_name', 'email'));
	}
=======
    protected $fillable = array('question', 'answer','order', 'lang','thumbnail', 'answered_by','asked_by','is_published','filter_class','datalayer','tracking','active','slug','link_to_product_title','path','file_name','file_size');
=======
>>>>>>> a89cdcfcadf0e0d3342e49c36e4bfa850e185a22

	public $fillable = [
		'question',
		'answer',
		'is_published',
		'has_product_link',
		'product_link_nofollow',
		'slug',
		'meta_title',
		'meta_description',
		'path',
		'file_name',
		'file_size',
		'answered_by',
		'asked_by',
		'order',
		'link_to_product_title',
		'link_to_product',
		'lang',
		'filter_class',
		'datalayer',
		'tracking',
		'deleted_at'
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'question' => 'string',
		'answer' => 'string',
		'is_published' => 'boolean',
		'has_product_link' => 'boolean',
		'product_link_nofollow' => 'boolean',
		'slug' => 'string',
		'meta_title' => 'string',
		'path' => 'string',
		'file_name' => 'string',
		'file_size' => 'integer',
		'answered_by' => 'string',
		'asked_by' => 'string',
		'order' => 'integer',
		'link_to_product_title' => 'string',
		'link_to_product' => 'string',
		'lang' => 'string',
		'filter_class' => 'string',
		'datalayer' => 'string',
		'tracking' => 'string'
	];



<<<<<<< HEAD

public function user() {
  return $this->belongs_to(User::class)->select(array('id', 'username', 'first_name', 'last_name', 'email'));
}
>>>>>>> 3ca5f53dc8a62f4d5afc4db6692f6df4569cb0f3
=======
	public function user() {
	  return $this->belongs_to(User::class)->select(array('id', 'username', 'first_name', 'last_name', 'email'));
	}
>>>>>>> a89cdcfcadf0e0d3342e49c36e4bfa850e185a22


}
