<?php

namespace App\Listeners;

use App\Services\AccountService;
use App\Services\MailService;
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
     * @param CompanyExpireSoon $event
     * @return void
     */
    public function handle(CompanyExpireSoon $event)
    {
        $accountService = new AccountService();
        $admins = $accountService->getAccountRelateCompany($event->companies, true, true);
        $mailService = new MailService('CompanyExpireSoonMail', $admins);
        $admins->each(function($admin, $index) use ($event, $mailService) {
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
