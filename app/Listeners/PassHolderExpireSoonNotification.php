<?php

namespace App\Listeners;

use App\Mail\Success;
use App\Events\PassHolderExpireSoon;
use App\Services\AccountService;
use App\Services\MailService;
use App\Models\Company;

class PassHolderExpireSoonNotification extends BaseListener
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
    public function handle(PassHolderExpireSoon $event)
    {
        $passholders = $event->pass_holders;
        if ($passholders) {
            $accountService = new AccountService();
            $mailService = new MailService('PassHolderExpireSoonMail', null);

            //send cag admin
            $adminsCag = $accountService->allAirportAccounts();
            $mailService->sendMailToMutilAccounts(null, $passholders, null, $adminsCag);

            //send company admin
            $mailService->sendMailListPassHoldersToAdminCompany($passholders);
        }
    }
}
