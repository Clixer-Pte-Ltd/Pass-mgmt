<?php

namespace App\Listeners;

use App\Events\PassHolderExpired;

class PassHolderExpiredNotification
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
        //
    }
}
