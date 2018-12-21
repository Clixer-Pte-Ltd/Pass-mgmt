<?php

namespace App\Listeners;

use App\Models\Zone;
use App\Models\PassHolder;
use App\Mail\Success;
use App\Models\BackpackUser;
use App\Jobs\ProcessSendMail;
use App\Mail\PassHolderExpireSoonMail;
use App\Services\AccountService;
use App\Services\MailService;
use App\Listeners\BasePassHolderListener;

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
    public function handle($event)
    {
        $this->handlePassHolder($event, 'PassHolderExpiredMail', ['status' => PassHolder::BLACK_LIST]);
    }
}
