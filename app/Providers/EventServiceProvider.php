<?php

namespace App\Providers;

use App\Events\UserCreated;
use App\Events\AccountImported;
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
