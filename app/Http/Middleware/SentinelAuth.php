<?php



namespace App\Http\Middleware;

use Closure;
use Sentinel;

/**
 * Class SentinelAuth.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class SentinelAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Sentinel::check()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('admin.login'));
            }
        }

        return $next($request);
    }
}
