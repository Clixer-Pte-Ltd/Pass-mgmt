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
        $this->handleCompanyAccountCO($user);
        $this->handleAdminAccount($user);
    }

    private function handleCompanyAccountCO($user)
    {
        //add role user company co
        if (!$user->hasAnyRole(Role::all())
            && (session()->has(SESS_NEW_ACC_FROM_TENANT) || session()->has(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR))
            && (isset($user->tenant_id) || isset($user->sub_constructor_id) )) {
        }

        if ($user->is_imported) {
            event(new AccountImported($user));
        } else {
            ProcessSendMail::dispatch($user->email, new WelcomeMail($user));
        }
    }
    private function handleAdminAccount($user)
    {
//        if (!$user->hasAnyRole($roles)) {
//            $user->assignRole(CAG_ADMIN_ROLE);
//        }
    }
}
