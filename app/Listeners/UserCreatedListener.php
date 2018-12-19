<?php

namespace App\Listeners;

use App\Events\AccountImported;

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
        $this->handleTenantAccount($user);
        $this->handleSubContructorAccount($user);
        $this->handleAirportTeamAccount($user);
    }

    private function handleTenantAccount($user)
    {
        if (isset($user->tenant_id) && !$user->hasRole(TENANT_ROLE)) {
            $user->assignRole(TENANT_ROLE);
            if ($user->is_imported) {
                event(new AccountImported($user));
            } else {
            }
        }
    }

    private function handleSubContructorAccount($user)
    {
        if (isset($user->sub_constructor_id) && !$user->hasRole(SUB_CONSTRUCTOR_ROLE)) {
            $user->assignRole(SUB_CONSTRUCTOR_ROLE);
            if ($user->is_imported) {
                event(new AccountImported($user));
            } else {
            }
        }
    }

    private function handleAirportTeamAccount($user)
    {
        if (!isset($user->tenant_id) && !isset($user->sub_constructor_id)) {
            $user->assignRole(AIRPORT_TEAM_ROLE);
        }
    }
}
