<?php

namespace App\Listeners;

use App\Events\CompanyExpired;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompanyExpiredNotification extends BaseListener
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
     * @param  CompanyExpired  $event
     * @return void
     */
    public function handle(CompanyExpired $event)
    {
        $companies = $event->companies;
        foreach ($companies as $company) {
            $this->handldeCompany($company, 'CompanyExpiredMail');
        }
    }
}
