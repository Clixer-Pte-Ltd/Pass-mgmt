<?php

namespace App\Listeners;

use App\Events\CompanyAddAccount;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\MailService;

class CompanyAddAccountNotification
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
    public function handle(CompanyAddAccount $event)
    {
        $user = $event->user;
        $mailService = new MailService('CompanyNotifyNewAccount', null);
        $mailService->accountNotify($user);
    }
}
