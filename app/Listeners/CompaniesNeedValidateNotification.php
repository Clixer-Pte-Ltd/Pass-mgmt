<?php

namespace App\Listeners;

use App\Events\CompanyNeedValidate;

class CompaniesNeedValidateNotification extends BaseListener
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
    public function handle(CompanyNeedValidate $event)
    {
        $this->handldeCompany($event->companies, 'CompanyNeedValidateMail', false);
    }
}
