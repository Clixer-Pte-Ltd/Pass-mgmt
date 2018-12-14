<?php

namespace App\Http\Middleware;

use Closure;

class AdminOrTeam
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
        if (!backpack_user()->hasAnyRole([ADMIN_ROLE, AIRPORT_TEAM_ROLE])) {
            abort(401);
        }
        return $next($request);
    }
}
