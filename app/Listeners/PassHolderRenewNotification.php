<?php

namespace App\Listeners;

use App\Events\PassHolderRenew;

class PassHolderRenewNotification extends  BaseListener
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
    public function handle(PassHolderRenew $event)
    {
        $passHolders = $event->pass_holders;
        $this->handlePassHolder($passHolders, 'PassHolderRenewMail');
    }
}
