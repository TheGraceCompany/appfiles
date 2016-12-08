<?php

namespace App\Search\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class Search.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class Search extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'search';
    }
}
