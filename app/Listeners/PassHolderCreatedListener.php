<?php

namespace App\Listeners;

use App\Services\AccountService;
use App\Services\MailService;

class PassHolderCreatedListener extends BaseListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $passholder = $event->model;
        if ($passholder) {
            $accountService = new AccountService();
            $mailService = new MailService('CreatePassHolderSuccessMail', null);

            //send company admin
            $admins = $accountService->getCompanyAccountRelatedToPassHolder($passholder, $roles = [COMPANY_CO_ROLE, COMPANY_AS_ROLE]);
            $mailService->sendMailToMutilAccounts(null, $passholder, null, $admins);
        }
//        $this->handlePassHolder($event->model, 'CreatePassHolderSuccessMail');
    }
}
