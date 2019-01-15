<?php

namespace App\Http\Controllers\Admin;

use App\Models\PassHolder;
use App\Models\Tenant;
use Backpack\Base\app\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['2fa', backpack_middleware()]);
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $this->data['title'] = trans('backpack::base.dashboard'); // set the page title
        if(auth()->user()->hasAnyRole([ADMIN_ROLE, AIRPORT_TEAM_ROLE])) {
            $this->data['pass_holders'] = PassHolder::all();
        } else {
            $uen = backpack_user()->tenant ? backpack_user()->tenant->uen : backpack_user()->subConstructor->uen;
            $this->data['pass_holders'] = PassHolder::where('com    pany_uen', $uen)->get();
        }
        return view('dashboard.dashboard', $this->data);
    }

    /**
     * Redirect to the dashboard.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(backpack_url('dashboard'));
    }
}
