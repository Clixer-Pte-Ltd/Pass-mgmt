<?php

namespace App\Listeners;

use App\Models\Zone;
use App\Mail\Success;
use App\Models\BackpackUser;
use App\Jobs\ProcessSendMail;
use App\Mail\CreatePassHolderSuccessMail;
use App\Services\AccountService;
use App\Services\MailService;
use App\Listeners\BasePassHolderListener;

class PassHolderCreatedListener extends BasePassHolderListener
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
        $passHolder = $event->model;
        $this->handlePassHolder($event, 'CreatePassHolderSuccessMail');
    }
}
