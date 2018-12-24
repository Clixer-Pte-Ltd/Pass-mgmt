<?php

namespace App\Listeners;

use App\Mail\Success;

class PassHolderCreatedListener extends BaseListener
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
        $this->handlePassHolder($passHolder, 'CreatePassHolderSuccessMail');
    }
}
