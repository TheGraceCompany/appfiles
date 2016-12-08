<?php

/*
 * @author Phillip Madsen
 */

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'subtitle',
        'status',
        'office_status',
        'availability',
        'slug',
        'ispromo',
        'isDev',
        'hasWarranty',
        'is_published',
        'manufacturer',
        'details',
        'description',
        'price_heading',
        'features_heading',
        'additional_heading',
        'reviews_heading',
        'waranty_heading',
        'support_heading',
        'docs_heading',
        'price',
        'model',
        'sku',
        'upc',
        'quantity',
        'thumbnail',
        'thumbnail2',
        'thumbnail3',
        'photo_album',
        'pubished_at',
        'video_url',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'facebook_title',
        'google_plus_title',
        'twitter_title',
        'reviews_tab',
        'warranty_tab',
        'docs_tab',
        'support_tab',
        'datalayer',
        'tracking',
    ];

    // public function model()
    // {
    //     return Product::class;
    // }

    // public function all()
    // {
    //     return $this->product->all();
    // }

    // public function all()
    // {
    //     return $this->product->with('tags')->orderBy('created_at', 'DESC')->where('is_published', 1)->where('lang', $this->getLang())->get();
    // }

    // public function getLastProduct($limit)
    // {
    //     return $this->product->orderBy('created_at', 'desc')->where('lang', $this->getLang())->take($limit)->offset(0)->get();
    // }

    // public function lists()
    // {
    //     return $this->product->get()->where('lang', $this->getLang())->lists('title', 'id');
    // }
}
