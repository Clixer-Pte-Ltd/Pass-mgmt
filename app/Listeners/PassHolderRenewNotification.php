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
        $passHolder = $event->pass_holder;
        $this->handlePassHolder($passHolder, 'PassHolderRenewMail');
    }
}
