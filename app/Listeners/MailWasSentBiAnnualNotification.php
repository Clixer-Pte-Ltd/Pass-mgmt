<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\AccountService;
use App\Services\MailService;
use App\Events\MailWasSentBiAnnual;

class MailWasSentBiAnnualNotification
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
    public function handle(MailWasSentBiAnnual $event)
    {
        $accountService = new AccountService();
        $admins = $accountService->allCoTenantAccount();

        $mailService = new MailService('BiAnnualMail', $admins);
        $mailService->sendMailToMutilAccounts();
    }
}
