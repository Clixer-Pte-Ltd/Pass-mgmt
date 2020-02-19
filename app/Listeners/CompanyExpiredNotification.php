<?php

namespace App\Listeners;

use App\Events\CompanyExpired;
use App\Services\AccountService;
use App\Services\MailService;
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
     * @param CompanyExpired $event
     * @return void
     */
    public function handle(CompanyExpired $event)
    {
        $accountService = new AccountService();
        $admins = $accountService->getAccountRelateCompany($event->companies, true, true);
        $mailService = new MailService('CompanyExpiredMail', $admins);
        $admins->each(function ($admin, $index) use ($event, $mailService) {
            if ($admin->hasCompany()) {
                $ids = $event->type == TENANT ? $admin->getAllTenants()->pluck('id')->toArray()
                    : $admin->getSubConstructors()->pluck('id')->toArray();
                $companies = $event->companies->whereIn('id', $ids);
                if ($companies->count()) {
                    $mailService->sendMailToAccount($admin, $companies);
                }
            }
            if ($admin->hasAnyRole(config('backpack.cag.roles'))) {
                $mailService->sendMailToAccount($admin, $event->companies);
            }
        });
    }
}
