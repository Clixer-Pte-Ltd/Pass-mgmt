<?php

namespace App\Listeners;

use App\Jobs\ProcessSendMail;
use App\Mail\AccountInfo;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountInfoNotification
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

        $account = $event->model;
        dispatch(new ProcessSendMail($account, new AccountInfo($account)));
//        Mail::to($account)->send(new AccountInfo($account));
    }
}
