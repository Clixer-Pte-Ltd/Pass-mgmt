<?php

namespace App\Listeners;

use App\Events\PassHolderRenewed;

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
    public function handle(PassHolderRenewed $event)
    {
        $passHolders = $event->pass_holders;
        $this->handlePassHolder($passHolders, 'PassHolderRenewMail');
    }
}
