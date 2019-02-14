<?php

namespace App\Providers;

use App\Events\CompanyWasNotValidate;
use App\Events\UserCreated;
use App\Events\AccountImported;
use App\Listeners\CompanyWasNotValidateNotification;
use Illuminate\Support\Facades\Event;
use App\Listeners\UserCreatedListener;
use Illuminate\Auth\Events\Registered;
use App\Listeners\AccountInfoNotification;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\PassHolderCreated;
use App\Listeners\AddZoneToNewlyPassHolder;
use App\Listeners\PassHolderCreatedListener;
use App\Events\CompanyExpired;
use App\Listeners\CompanyExpiredNotification;
use App\Events\PassHolderExpireSoon;
use App\Listeners\PassHolderExpireSoonNotification;
use App\Events\PassHolderExpired;
use App\Listeners\PassHolderExpiredNotification;
use App\Events\CompanyExpireSoon;
use App\Listeners\CompanyExpireSoonNotification;
use App\Events\AdhocEmailCreated;
use App\Listeners\AdhocEmailNotification;
use App\Events\PassHolderRenewed;
use App\Listeners\PassHolderRenewNotification;
use App\Events\CompanyNeedValidate;
use App\Listeners\CompaniesNeedValidateNotification;
use App\Events\CompanyAddAccount;
use App\Listeners\CompanyAddAccountNotification;
use App\Events\PassHolderNeedConfirmReturn;
use App\Listeners\PassHolderNeedConfirmReturnNotification;
use App\Events\MailWasSentBiAnnual;
use App\Listeners\MailWasSentBiAnnualNotification;
use App\Events\PassHolderValidDaily;
use App\Listeners\PassHolderValidDailyNotification;
use App\Events\PassHolderListPendingReturn;
use App\Listeners\PassHolderListPendingReturnNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserCreated::class => [
            UserCreatedListener::class,
        ],
        AccountImported::class => [
            AccountInfoNotification::class
        ],
        PassHolderCreated::class => [
            AddZoneToNewlyPassHolder::class,
            PassHolderCreatedListener::class
        ],
        CompanyExpired::class => [
            CompanyExpiredNotification::class
        ],
        PassHolderExpireSoon::class => [
            PassHolderExpireSoonNotification::class
        ],
        PassHolderExpired::class => [
            PassHolderExpiredNotification::class
        ],
        CompanyExpireSoon::class => [
            CompanyExpireSoonNotification::class
        ],
        AdhocEmailCreated::class => [
            AdhocEmailNotification::class
        ],
        PassHolderRenewed::class => [
            PassHolderRenewNotification::class
        ],
        CompanyNeedValidate::class => [
            CompaniesNeedValidateNotification::class
        ],
        CompanyWasNotValidate::class => [
            CompanyWasNotValidateNotification::class
        ],
        CompanyAddAccount::class => [
            CompanyAddAccountNotification::class
        ],
        PassHolderNeedConfirmReturn::class => [
            PassHolderNeedConfirmReturnNotification::class
        ],
        MailWasSentBiAnnual::class => [
            MailWasSentBiAnnualNotification::class
        ],
        PassHolderValidDaily::class => [
            PassHolderValidDailyNotification::class
        ],
        PassHolderListPendingReturn::class => [
            PassHolderListPendingReturnNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
