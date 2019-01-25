<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\BackpackUser;

class CrudUser
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
        if (backpack_user()->hasRole(CAG_ADMIN_ROLE)) {
            return $next($request);
        }
        if (!backpack_user()->hasAnyRole([TENANT_CO_ROLE, SUB_CONSTRUCTOR_CO_ROLE])) {
            abort(401);
        }
        $userId = intval($request->route('user'));
        if ($userId) {
            $user = BackpackUser::find(intval($request->route('user')));
            if ($user->hasCompany() && $user->getCompany()->id !== backpack_user()->getCompany()->id) {
                abort(401);
            }
        }
        return $next($request);
    }
}
