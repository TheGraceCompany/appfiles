<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class SearchServiceProvider.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class SearchServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('search', 'App\Search\Search');
    }
}
