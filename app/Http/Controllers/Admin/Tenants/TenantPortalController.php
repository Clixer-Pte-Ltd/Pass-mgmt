<?php

namespace App\Http\Controllers\Admin\Tenants;

use App\Http\Controllers\Controller;

class TenantPortalController extends Controller
{
    public function my_company()
    {
        session()->put(SESS_TENANT_MY_COMPANY, backpack_user()->tenant ? backpack_user()->tenant->id : backpack_user()->subConstructor->id);
        session()->forget(SESS_TENANT_2FA);
        session()->forget(SESS_SUB_CONSTRUCTOR_2FA);
        return view('profile.tenants.my_company', ['entry' => backpack_user()->tenant ?? backpack_user()->subConstructor]);
    }
}
