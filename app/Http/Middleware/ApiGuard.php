<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 10.04.18
 * Time: 16:59
 */

namespace App\Http\Middleware;


use Illuminate\Support\Facades\Auth;

use Closure;

class ApiGuard
{

    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
        return $next($request);
    }

}
