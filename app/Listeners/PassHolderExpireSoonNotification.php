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
        $passHolders = $event->pass_holders;
        foreach ($passHolders as $pass) {
            $this->handlePassHolder($pass, 'PassHolderExpireSoonMail');
        }
    }
}
