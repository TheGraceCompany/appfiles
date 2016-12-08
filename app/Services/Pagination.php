<?php



namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class Pagination
{
    /**
     * Paginator.
     *
     * @param $data
     * @param $total
     * @param $perPage
     *
     * @return LengthAwarePaginator
     */
    public static function makeLengthAware($data, $total, $perPage)
    {
        return new LengthAwarePaginator($data, $total, $perPage, Paginator::resolveCurrentPage(), [
            'path' => Paginator::resolveCurrentPath(),
        ]);
    }
}
