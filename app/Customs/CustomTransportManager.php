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
            'driver' => 'smtp',
            'host' => getSettingValueByKey(SMTP_HOST),
            'port' => getSettingValueByKey(SMTP_PORT),
            'from' => [
                'address' => 'cag@example.com',
                'name' => 'CAG Pass Management Notification'
            ],
            'encryption' => getSettingValueByKey(SMTP_ENCRYPTION),
            'username' => getSettingValueByKey(SMTP_USERNAME),
            'password' => getSettingValueByKey(SMTP_PASSWORD),
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
