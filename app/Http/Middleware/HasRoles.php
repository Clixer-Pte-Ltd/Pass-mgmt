<?php

namespace App\Http\Middleware;

use Closure;

class HasRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles = '')
    {
        if (!backpack_user()->hasAnyRole(explodeCag($roles))) {
            abort(401);
        }
        return $next($request);
    }
}
