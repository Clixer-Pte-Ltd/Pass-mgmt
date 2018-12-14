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
