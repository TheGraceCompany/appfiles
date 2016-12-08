<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Sentinel::getUser()->inRole('Admin'))
        {
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                return back()->withInput()->withErrors(trans('admin.login'));
            }
        }

        return $next($request);

    }
}
