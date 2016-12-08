<?php

namespace App\Feeder\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class Feeder.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class Feeder extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'feeder';
    }
}
