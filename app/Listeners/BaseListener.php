<?php

namespace App\Listeners;

use App\Mail\Success;
use App\Services\AccountService;
use App\Services\MailService;

class BaseListener
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
    public function handlePassHolder($passHolders, $mailFormName = null)
    {
        if (isset($mailFormName)) {
            $mailService = new MailService($mailFormName, null);
            $mailService->passHolderNotify($passHolders);
        }
    }

    public function handldeCompany ($companies, $mailFormName = null, $hasAirportPassTeam = true, $hasAdminCompay = true, $content = null)
    {
        if (isset($mailFormName)) {
            $accountService = new AccountService();
            $admins = $accountService->getAccountRelateCompany($companies, $hasAirportPassTeam, $hasAdminCompay);
            $mailService = new MailService($mailFormName, $admins);
            $mailService->companiesNotify($companies, $content);
        }
    }
}
