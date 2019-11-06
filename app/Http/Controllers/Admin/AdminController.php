<?php

namespace App\Http\Controllers\Admin;

use App\Models\PassHolder;
use App\Models\Tenant;
use Backpack\Base\app\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['2fa', backpack_middleware(), 'checkChangePasswordFirst']);
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $this->data['title'] = trans('backpack::base.dashboard'); // set the page title
        if(backpack_user()->hasAnyRole(config('backpack.cag.roles'))) {
            $pass_holders = PassHolder::all();
            $this->data['pass_holders'] = PassHolder::orderBy('id', 'desc')->take(25)->get();
        } else {
            $uens = backpack_user()->getCompany()->pluck('uen')->toArray();
            $pass_holders = PassHolder::whereIn('company_uen', $uens)->get();
            $this->data['pass_holders'] = PassHolder::whereIn('company_uen', $uens)->orderBy('id', 'desc')->take(25)->get();
        }

        $logsActivePassHolder = Activity::where('description', 'Pass Holder Valid Daily Count')
            ->where('created_at', '<=', Carbon::now())
            ->where('created_at', '>=', Carbon::now()->subDay(7))
            ->orderBy('created_at', 'asc')
            ->get();

        // passholder activate
        $this->data['pass_holders_active_count'] = [];
        foreach ($logsActivePassHolder as $log) {
            $this->data['pass_holders_active_count'][] = $log->getExtraProperty('count');
        }

        // pass expire in 4
        $this->data['pass_holders_expireIn4Weeks'] = $pass_holders->where('pass_expiry_date','<=', Carbon::now()->addWeeks(4))->where('pass_expiry_date','>', Carbon::now());
        $this->data['pass_holders_expireIn4Weeks_count'] = [];
        for ($i = 6; $i >=0 ; $i--) {
            $this->data['pass_holders_expireIn4Weeks_count'][] = $pass_holders->where('pass_expiry_date','<=', Carbon::now()->subDay($i)->addWeeks(4))->where('pass_expiry_date','>', Carbon::now())->count();
        }

        // pass activate
        $this->data['pass_holders_active'] = $pass_holders->where('status', PASS_STATUS_VALID);

        // pass pending return
        $this->data['pass_pending_return'] = $pass_holders->whereIn('status', [PASS_STATUS_BLACKLISTED, PASS_STATUS_WAITING_CONFIRM_RETURN]);

        $expiring_tenants_within_4_weeks = backpack_user()->hasAnyRole(config('backpack.cag.roles')) ? Company::getAllCompaniesWithin4Weeks() : collect([]);

        $this->data['total_pass'] = $pass_holders->count();
        $this->data['total_company'] = Company::getAllCompanies()->count();

        $this->data['count_pass_holders_expireIn4Weeks'] = $this->data['pass_holders_expireIn4Weeks']->count();
        $this->data['pass_holders_expireIn4Weeks'] = $this->data['pass_holders_expireIn4Weeks']->slice(0, 25);
        $this->data['active_count'] = $this->data['pass_holders_active']->count();
        $this->data['pass_pending_return_count'] = $this->data['pass_pending_return']->count();
        $this->data['expiring_tenants_within_4_weeks_count'] = $expiring_tenants_within_4_weeks->count();
        $this->data['expiring_tenants_within_4_weeks'] = $expiring_tenants_within_4_weeks->slice(0, 25);

        return view('dashboard.dashboard', $this->data);
    }

    /**
     * Redirect to the dashboard.
     *
     * @return Redirector|RedirectResponse
     */
    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(backpack_url('dashboard'));
    }
}
