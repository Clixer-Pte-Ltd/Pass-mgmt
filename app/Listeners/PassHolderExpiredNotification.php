<?php

namespace App\Listeners;

use App\Models\Zone;
use App\Mail\Success;
use App\Models\BackpackUser;
use App\Jobs\ProcessSendMail;
use App\Mail\PassHolderExpireSoonMail;
use App\Services\AccountService;
use App\Services\MailService;
use App\Listeners\BasePassHolderListener;
use App\Events\PassHolderExpired;

class PassHolderExpiredNotification extends BasePassHolderListener
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
        $passHolders = $event->pass_holders;
        foreach ($passHolders as $pass) {
            $this->handlePassHolder($pass, 'PassHolderExpiredMail');
        }
    }
}
