<?php

namespace App\Http\Middleware;

use Closure;

class AdminCag
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!backpack_user()->hasAnyRole([CAG_ADMIN_ROLE])) {
            abort(401);
        }
        return $next($request);
    }
}
