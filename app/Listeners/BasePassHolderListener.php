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
    public function handlePassHolder($event, $mailFormName)
    {
        $pass_holder = $event->model;
        $accountService = new AccountService($pass_holder);
        $admins = $accountService->getAccountRelatedToPassHolder();
        $mailService = new MailService($mailFormName, $admins);
        $mailService->passHolderNotify($pass_holder);
    }
}