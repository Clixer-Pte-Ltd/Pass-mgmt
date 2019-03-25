<?php

namespace App\Http\Controllers\Admin\Tenants;

use App\Http\Controllers\Controller;

class TenantPortalController extends Controller
{
    public function my_company()
    {
        $company = backpack_user()->tenant ?? backpack_user()->subConstructor ?? null;
        if (!is_null($company)) {
            if (backpack_user()->tenant) {
                session()->put(SESS_TENANT_MY_COMPANY, $company->id);
                session()->forget(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR);
                session()->put(SESS_NEW_ACC_FROM_TENANT, $company->id);
            } else {
                session()->put(SESS_TENANT_MY_COMPANY, $company->tenant_id ?? null);
                session()->forget(SESS_NEW_ACC_FROM_TENANT);
                session()->put(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR, $company->id ?? null);
            }
            session()->forget(SESS_TENANT_2FA);
            session()->forget(SESS_SUB_CONSTRUCTOR_2FA);
            return view('profile.tenants.my_company', ['entry' => $company]);
        }
       return abort(404);
    }
}
