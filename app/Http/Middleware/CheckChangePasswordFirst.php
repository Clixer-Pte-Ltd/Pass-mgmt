<?php

namespace App\Http\Middleware;

use Closure;

class CheckChangePasswordFirst
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
        if (!backpack_user()->change_first_pass_done) {
            return redirect()->route('admin.user.changeFirstPassword');
        }
        return $next($request);
    }
}
