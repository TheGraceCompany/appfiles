<?php



namespace App\Repositories;

use App\Models\Shippingmethod;

class ShippingmethodRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'method_title',
        'account_number',
        'delivery_confirmation',
        'dc_per_package_price',
        'pickup_type',
        'price_adjustment_flat',
        'price_adjustment_percent',
        'flag_residential',
        'add_insurance',
        'negotiated_rates',
        'weight',
        'measurement',
    ];

    /**
     * Configure the Model.
     **/
    public function model()
    {
        return Shippingmethod::class;
    }
}
