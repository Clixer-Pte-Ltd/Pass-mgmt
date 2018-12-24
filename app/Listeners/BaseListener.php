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
    public function handlePassHolder($passHolder, $mailFormName = null)
    {
        if (isset($mailFormName)) {
            $accountService = new AccountService();
            $admins = $accountService->getAccountRelatedToPassHolder($passHolder);
            $mailService = new MailService($mailFormName, $admins);
            $mailService->passHolderNotify($passHolder);
        }
    }

    public function handldeCompany ($company, $mailFormName = null)
    {
        if (isset($mailFormName)) {
            $accountService = new AccountService();
            $admins = $accountService->getAccountRelateCompany($company);
            $mailService = new MailService($mailFormName, $admins);
            $mailService->companyNotify($company);
        }
    }
}
