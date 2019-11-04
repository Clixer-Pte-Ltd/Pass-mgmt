<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\PassHolderListPendingReturn;
use App\Services\MailService;
use App\Services\AccountService;

class PassHolderListPendingReturnNotification
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
    public function handle(PassHolderListPendingReturn $event)
    {
        $passholders = $event->pass_holders;
        if ($passholders) {
            $accountService = new AccountService();
            $mailService = new MailService('PassHolderListIsPendingReturnMail', null);

            //send cag admin
            $adminsCag = $accountService->allAirportAccounts();
            $mailService->sendMailToMutilAccounts(null, $passholders, null, $adminsCag);
        }
    }
}
