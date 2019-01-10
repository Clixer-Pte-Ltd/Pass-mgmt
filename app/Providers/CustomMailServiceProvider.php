<?php

namespace App\Providers;

use Illuminate\Mail\MailServiceProvider;
use App\Customs\CustomTransportManager;

class CustomMailServiceProvider extends MailServiceProvider
{
    protected function registerSwiftTransport()
    {
        $this->app['swift.transport'] = $this->app->instance('mail_transport', function ($app) {
            return new CustomTransportManager($app);
        });
    }
}
