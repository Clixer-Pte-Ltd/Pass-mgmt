<?php

namespace App\Http\Controllers\Admin\Tenants;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class TenantPortalController extends Controller
{
    public function my_company()
    {
        $companies = backpack_user()->getCompany();

        if (!is_null($companies)) {
            if ($companies instanceof Collection) {
                session()->put(SESS_TENANT_MY_COMPANY, $companies->first()->id);
                session()->forget(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR);
                session()->put(SESS_NEW_ACC_FROM_TENANT, $companies->first()->id);
            } else {
                if(backpack_user()->tenant) {
                    session()->put(SESS_TENANT_MY_COMPANY, $companies->id);
                    session()->forget(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR);
                    session()->put(SESS_NEW_ACC_FROM_TENANT, $companies->id);
                } else {
                    session()->put(SESS_TENANT_MY_COMPANY, $companies->tenant_id ?? null);
                    session()->forget(SESS_NEW_ACC_FROM_TENANT);
                    session()->put(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR, $companies->id ?? null);
                }
            }
            session()->forget(SESS_TENANT_2FA);
            session()->forget(SESS_SUB_CONSTRUCTOR_2FA);
            return view('profile.tenants.my_company', ['entry' => $companies instanceof Collection ? $companies->first() : $companies]);
        }
       return abort(404);
    }
}
