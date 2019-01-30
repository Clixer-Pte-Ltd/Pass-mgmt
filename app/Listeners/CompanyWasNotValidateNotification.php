<?php

namespace App\Listeners;

use App\Events\CompanyWasNotValidate;
use App\Services\AccountService;
use App\Services\MailService;
use App\Jobs\ProcessSendMail;
use App\Mail\CompaniesListNotValidate;

class CompanyWasNotValidateNotification extends BaseListener
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
    public function handle(CompanyWasNotValidate $event)
    {
        $accountService = new AccountService();
        $admins = $accountService->getAccountRelateCompany($event->companies, true, false);

        $mailService = new MailService('CompaniesListNotValidate', $admins);
        $mailService->sendMailToMutilAccounts(null, $event->companies);
    }
}
