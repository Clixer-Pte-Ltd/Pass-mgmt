<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Collection;

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
            if (backpack_user()->hasRole(COMPANY_CO_ROLE) && backpack_user()->tenant->id !== $tenant_id) {
                abort(401);
            }
        }

        $sub_constructor_id = intval($request->route('sub_constructor'));
        if ($sub_constructor_id && backpack_user()->hasRole(COMPANY_CO_ROLE)) {
            if (backpack_user()->tenant && !backpack_user()->tenant->subContructors->contains('id', $sub_constructor_id)) {
                abort(401);
            }
            if (backpack_user()->subConstructor && backpack_user()->subConstructor->id !== $sub_constructor_id) {
                abort(401);
            }
        }

        $pass_holder_id = intval($request->route('tenant_pass_holder'));
        if ($pass_holder_id) {
            if (!$this->handlePassHolder($pass_holder_id)) {
                abort(401);
            }
        }

        return $next($request);
    }

    public function handlePassHolder($pass_holder_id)
    {
        $companies = backpack_user()->getCompany() instanceof Collection ? backpack_user()->getCompany() : collect([backpack_user()->getCompany()]);
        if ($pass_holder_id && backpack_user()->hasCompany() && $companies) {
            foreach ($companies as $company) {
                if ($company->passholders->contains('id', $pass_holder_id)) {
                    return true;
                }
            }
        }
        return false;
    }
}
