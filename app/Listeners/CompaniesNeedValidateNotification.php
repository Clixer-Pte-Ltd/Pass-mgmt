<?php

namespace App\Listeners;

use App\Events\CompanyNeedValidate;
use App\Services\AccountService;
use App\Services\MailService;

class CompaniesNeedValidateNotification extends BaseListener
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
    public function handle(CompanyNeedValidate $event)
    {
        $accountService = new AccountService();
        $admins = $accountService->getAccountRelateCompany($event->companies, false, true);
        $mailService = new MailService('CompanyNeedValidateMail', $admins);
        $mailService->sendMailToMutilAccounts(null, $event->companies);

    }
}
