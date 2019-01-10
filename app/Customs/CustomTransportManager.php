<?php

namespace App\Customs;

use Illuminate\Mail\TransportManager;

//my models are located in app\models

class CustomTransportManager extends TransportManager
{
    /**
     * Create a new manager instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;

        $this->app['config']['mail'] = [
            'driver' => env('MAIL_DRIVER', 'smtp'),
            'host' => getSettingValueByKey(SMTP_HOST) ?: env('MAIL_HOST', 'smtp.mailgun.org'),
            'port' => getSettingValueByKey(SMTP_HOST) ?: env('MAIL_PORT', 587),
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS', 'cag@example.com'),
                'name' => env('MAIL_FROM_NAME', 'CAG Pass Management Notification')
            ],
            'encryption' => getSettingValueByKey(SMTP_ENCRYPTION) ?: env('MAIL_ENCRYPTION', 'tls'),
            'username' => getSettingValueByKey(SMTP_USERNAME) ?: env('MAIL_USERNAME'),
            'password' => getSettingValueByKey(SMTP_PASSWORD) ?: env('MAIL_PASSWORD'),
            'sendmail' => '/usr/sbin/sendmail -bs',
            'markdown' => [
                'theme' => 'default',

                'paths' => [
                    resource_path('views/vendor/mail'),
                ],
            ],
            'log_channel' => env('MAIL_LOG_CHANNEL'),
        ];
    }
}
