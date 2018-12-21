<?php

namespace App\Listeners;

use App\Models\Zone;
use App\Mail\Success;
use App\Models\BackpackUser;
use App\Jobs\ProcessSendMail;
use App\Mail\PassHolderExpireSoonMail;
use App\Services\AccountService;
use App\Services\MailService;

class BasePassHolderListener
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
    public function handlePassHolder($event, $mailFormName = null, $dataPassHolder = null)
    {
        $passHolder = $event->model;
        if (isset($mailFormName)) {
            $accountService = new AccountService($passHolder);
            $admins = $accountService->getAccountRelatedToPassHolder();
            $mailService = new MailService($mailFormName, $admins);
            $mailService->passHolderNotify($passHolder);
        }

        if (isset($dataPassHolder)) {
           $passHolder->update($dataPassHolder);
        }
    }
}
