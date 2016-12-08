<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Feeder\Feeder;

/**
 * Class FeederServiceProvider.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class FeederServiceProvider extends ServiceProvider
{
    /**
     * Register.
     */
    public function register()
    {
        $this->app->bind('feeder', 'App\Feeder\Feeder');
    }
}
