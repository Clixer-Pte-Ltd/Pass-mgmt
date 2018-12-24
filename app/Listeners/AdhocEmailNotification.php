<?php

namespace App\Listeners;

use App\Events\AdhocEmailCreated;

class AdhocEmailNotification
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
    public function handle(AdhocEmailCreated $event)
    {
        $email = $event->email;
        $companies = $email->destinations;

        // @TODO: Sending email here
        dd($email->subject, $email->body, $companies);
    }
}
