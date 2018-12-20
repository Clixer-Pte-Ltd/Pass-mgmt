<?php

namespace App\Listeners;

use App\Models\Zone;

class AddZoneToNewlyPassHolder
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
        if (session()->has(SESS_ZONES)) {
            $zones = session()->get(SESS_ZONES);
            session()->forget(SESS_ZONES);
            $zone_ids = Zone::whereIn('name', $zones)->pluck('id');
            $pass_holder->zones()->sync($zone_ids);
        }
    }
}