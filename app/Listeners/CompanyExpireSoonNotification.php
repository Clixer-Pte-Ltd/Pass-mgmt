<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\CompanyExpireSoon;

class CompanyExpireSoonNotification extends BaseListener
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
    public function handle(CompanyExpireSoon $event)
    {
        $companies = $event->companies;
        foreach ($companies as $company) {
            $this->handldeCompany($company, 'CompanyExpireSoonMail');
        }
    }
}
