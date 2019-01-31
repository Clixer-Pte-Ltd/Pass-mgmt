<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\PassHolderValidDaily;
use App\Services\MailService;
use App\Services\AccountService;
use App\Models\Company;
use App\Models\PassHolder;
use App\Models\Tenant;
use Carbon\Carbon;

class PassHolderValidDailyNotification extends BaseListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PassHolderValidDaily $event)
    {
        $mailService = new MailService('PassHolderValidDailyMail', null);
        $accountService = new AccountService();
        $totalPass = collect([]);
        foreach (Company::getAllCompanies() as $company) {
            $passHolders = $company->passHolders()
                ->where('status', PASS_STATUS_VALID)
                ->where('pass_expiry_date', '>=', Carbon::now())
                ->get();

            $adminsCompany = $accountService->allCompanyAccountHasRoles(true, true , [COMPANY_CO_ROLE, COMPANY_AS_ROLE], $company);
            if ($passHolders->count()) {
                $mailService->sendMailToMutilAccounts(null, $passHolders, $extraData = [], $adminsCompany);
            }
            $totalPass = linkCollection($totalPass, $passHolders);
        }

        $adminsCAG = $accountService->allAirportAccounts();
        if ($totalPass->count()) {
            $mailService->sendMailToMutilAccounts(null, $totalPass, $extraData = [], $adminsCAG);
        }
    }
}
