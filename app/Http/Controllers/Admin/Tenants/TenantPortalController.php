<?php

namespace App\Http\Controllers\Admin\Tenants;

use App\Http\Controllers\Controller;

class TenantPortalController extends Controller
{
    public function my_company()
    {
        if (backpack_user()->tenant) {
            session()->put(SESS_TENANT_MY_COMPANY, backpack_user()->tenant->id);
            session()->forget(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR);
            session()->put(SESS_NEW_ACC_FROM_TENANT, backpack_user()->tenant->id);
        } else {
            session()->put(SESS_TENANT_MY_COMPANY, backpack_user()->subConstructor->tenant_id);
            session()->forget(SESS_NEW_ACC_FROM_TENANT);
            session()->put(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR, backpack_user()->subConstructor->id);
        }
        session()->forget(SESS_TENANT_2FA);
        session()->forget(SESS_SUB_CONSTRUCTOR_2FA);
        return view('profile.tenants.my_company', ['entry' => backpack_user()->tenant ?? backpack_user()->subConstructor]);
    }
}
