<?php


namespace App\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Backpack\Base\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;

class ResetPassword extends ResetPasswordNotification implements ShouldQueue
{
    use Queueable;
}
