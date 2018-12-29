<?php

namespace App\Listeners;

use App\Events\AdhocEmailCreated;

class AdhocEmailNotification extends BaseListener
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
    public function handle(AdhocEmailCreated $event)
    {
        $email = $event->email;
        $companies = $email->destinations;
        $companiesRelate = collect();
        foreach ($companies as $company) {
            $companiesRelate->push($company->companyable);
        }
        $this->handldeCompany($companiesRelate, 'AdhocMail', false, true, $email);
    }
}
