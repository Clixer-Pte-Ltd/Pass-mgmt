<?php

namespace App\Models;

use App\User;
use Backpack\Base\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Tightenco\Parental\HasParentModel;

class BackpackUser extends User
{
    use HasParentModel;

    protected $table = 'users';

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function subConstructor()
    {
        return $this->belongsTo(SubConstructor::class);
    }

    public function hasCompany()
    {
        return is_null($this->tenant) && is_null($this->subConstructor) ? false : true; // false if user is admin or airport pass team
    }
}
