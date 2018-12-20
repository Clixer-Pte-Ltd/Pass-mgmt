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
        $this->handleAddZoneToNewlyPassHolder($pass_holder);
        $this->handleSendMailSuccess($pass_holder);
    }

    private function handleAddZoneToNewlyPassHolder($pass_holder)
    {
        if (session()->has(SESS_ZONES)) {
            $zones = session()->get(SESS_ZONES);
            session()->forget(SESS_ZONES);
            $zone_ids = Zone::whereIn('name', $zones)->pluck('id');
            $pass_holder->zones()->sync($zone_ids);
        }
    }

    private function handleSendMailSuccess($pass_holder)
    {
        $admins = BackpackUser::role(AIRPORT_TEAM_ROLE)->get();
        $companyAdmin = $pass_holder->company->getCompanyModel();
        if (isset($companyAdmin)) {
            $admins = $admins->merge($companyAdmin->accounts);
        }
        $admins->map(function($admin, $index) use ($pass_holder) {
            ProcessSendMail::dispatch($admin->email, new CreatePassHolderSuccessMail($pass_holder, $admin));
        });
    }
}
