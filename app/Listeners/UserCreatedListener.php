<?php

namespace App\Listeners;

use App\Events\AccountImported;
use App\Mail\WelcomeMail;
use App\Jobs\ProcessSendMail;
use App\Models\Role;

class UserCreatedListener
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
        $user = $event->model;
        ProcessSendMail::dispatch($user->email, new WelcomeMail($user), env('SERVER_TYPE'));
    }
}
