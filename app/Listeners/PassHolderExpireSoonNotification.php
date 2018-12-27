<?php

namespace App\Listeners;

use App\Mail\Success;
use App\Events\PassHolderExpireSoon;

class PassHolderExpireSoonNotification extends BaseListener
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
    public function handle(PassHolderExpireSoon $event)
    {
        $this->handlePassHolder($event->pass_holders, 'PassHolderExpireSoonMail');
    }
}
