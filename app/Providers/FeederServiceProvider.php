<?php



namespace App\Providers;

use App\Feeder\Feeder;
use Illuminate\Support\ServiceProvider;

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
