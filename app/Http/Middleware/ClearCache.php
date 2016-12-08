<?php

/*
 * @author Phillip Madsen
 */

namespace App\Http\Middleware;

use Artisan;
use Closure;

class ClearCache
{
    public function handle($request, Closure $next)
    {
        Artisan::call('view:clear');

        return $next($request);
    }
}
