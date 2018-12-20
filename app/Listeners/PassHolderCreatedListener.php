<?php

namespace App\Listeners;

use App\Models\Zone;
use App\Mail\Success;
use App\Models\BackpackUser;
use App\Jobs\ProcessSendMail;
use App\Mail\CreatePassHolderSuccessMail;

class PassHolderCreatedListener
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
        $pass_holder = $event->model;
        $admins = BackpackUser::role(AIRPORT_TEAM_ROLE)->get();
        $companyOfPassHolder = $pass_holder->company->companyable;
        if (isset($companyOfPassHolder)) {
            $admins = $admins->merge($companyOfPassHolder->accounts);
        }
        $admins->map(function($admin, $index) use ($pass_holder) {
            ProcessSendMail::dispatch($admin->email, new CreatePassHolderSuccessMail($pass_holder, $admin));
        });
    }
}
