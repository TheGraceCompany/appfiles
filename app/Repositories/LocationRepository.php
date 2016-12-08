<?php



namespace App\Repositories;

use App\Models\Location;

class LocationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'location_type',
        'nickname',
        'address',
        'street',
        'street_additional',
        'city',
        'state',
        'country',
        'zipcode',
        'latitude',
        'longitude',
    ];

    /**
     * Configure the Model.
     */
    public function model()
    {
        return Location::class;
    }
}
