<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\PassHolderNeedConfirmReturn;
use App\Services\AccountService;
use App\Jobs\ProcessSendMail;
use App\Mail\PassHolderNeedConfirmReturnMail;
use App\Services\MailService;

class PassHolderNeedConfirmReturnNotification extends BaseListener
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
    public function handle(PassHolderNeedConfirmReturn $event)
    {
        $accountService = new AccountService();
        $admins = $accountService->getAccountRelateCompany(null, true, false);

        $mailService = new MailService('PassHolderNeedConfirmReturnMail', $admins);
        $mailService->sendMailToMutilAccounts(null, $event->pass_holder, ['isListPass' => $event->is_list_pass]);
    }
}
