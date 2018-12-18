<?php

namespace App\Http\Middleware;

use Closure;

class CompanyOwner
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
        $tenant_id = intval($request->route('tenant'));

        if ($tenant_id) {
            if (backpack_user()->hasRole(TENANT_ROLE) && backpack_user()->tenant->id !== $tenant_id) {
                abort(401);
            }
        }

        $sub_constructor_id = intval($request->route('sub_constructor'));

        if ($sub_constructor_id) {
            if (backpack_user()->hasRole(TENANT_ROLE) && !backpack_user()->tenant->subContructors->contains('id', $sub_constructor_id)) {
                abort(401);
            }
            if (backpack_user()->hasRole(SUB_CONSTRUCTOR_ROLE) && backpack_user()->subConstructor->id !== $sub_constructor_id) {
                abort(401);
            }
        }

        return $next($request);
    }
}