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
        $this->handleTenantAccount($user);
        $this->handleSubContructorAccount($user);
        $this->handleAdminAccount($user);
    }

    private function handleTenantAccount($user)
    {
        //add role user company co
        if (!$user->hasAnyRole(Role::all()) && session()->has(SESS_NEW_ACC_FROM_TENANT) && isset($user->tenant_id)) {
            $user->assignRole(TENANT_CO_ROLE_ID);
            if ($user->is_imported) {
                event(new AccountImported($user));
            } else {
                ProcessSendMail::dispatch($user->email, new WelcomeMail($user));
            }
        }
    }

    private function handleSubContructorAccount($user)
    {
        if (!$user->hasAnyRole(Role::all()) && session()->has(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR) && isset($user->sub_constructor_id)) {
            $user->assignRole(SUB_CONSTRUCTOR_CO_ROLE_ID);
            if ($user->is_imported) {
                event(new AccountImported($user));
            } else {
                ProcessSendMail::dispatch($user->email, new WelcomeMail($user));
            }
        }

    }

    private function handleAdminAccount($user)
    {
        if (!isset($user->tenant_id) && !isset($user->sub_constructor_id)) {
            $user->assignRole(CAG_ADMIN_ROLE);
        }
    }
}
