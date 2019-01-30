<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\PassHolderNeedConfirmReturn;
use App\Services\AccountService;
use App\Jobs\ProcessSendMail;
use App\Mail\PassHolderNeedConfirmReturnMail;

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
        foreach ($admins as $admin) {
            ProcessSendMail::dispatch($admin->email, new PassHolderNeedConfirmReturnMail($event->pass_holder, $admin, ['isListPass' => $event->is_list_pass]));
        }
    }
}
