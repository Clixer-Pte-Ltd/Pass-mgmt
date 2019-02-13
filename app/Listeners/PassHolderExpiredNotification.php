<?php

namespace App\Listeners;

use App\Models\Company;
use App\Models\Zone;
use App\Mail\Success;
use App\Models\BackpackUser;
use App\Jobs\ProcessSendMail;
use App\Mail\PassHolderExpireSoonMail;
use App\Services\AccountService;
use App\Services\MailService;
use App\Events\PassHolderExpired;
use phpDocumentor\Reflection\Types\Null_;

class PassHolderExpiredNotification extends BaseListener
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
    public function handle(PassHolderExpired $event)
    {
        $passholders = $event->pass_holders;
        if ($passholders) {
            $accountService = new AccountService();
            $mailService = new MailService('PassHolderExpiredMail', null);

            //send cag admin
            $adminsCag = $accountService->allAirportAccounts();
            $mailService->sendMailToMutilAccounts(null, $passholders, null, $adminsCag);

            //send company admin
            $mailService->sendMailListPassHoldersToAdminCompany($passholders);
        }
    }
}
