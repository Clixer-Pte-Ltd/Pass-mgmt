<?php

namespace App\Models;

use App\User;
use Backpack\Base\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Tightenco\Parental\HasParentModel;
use App\Traits\LogsActivity;

class BackpackUser extends User
{
    use HasParentModel;
    use LogsActivity;

    protected $table = 'users';
    protected static $logFillable = true;

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
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function hasCompany()
    {
        return is_null($this->tenant) && is_null($this->subConstructor) ? false : true; // false if user is admin or airport pass team
    }

    public function getCompany()
    {
        $company = $this->hasCompany() && $this->tenant? $this->tenant : $this->subConstructor;
        return isset($company) ? $company : null;
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function subConstructor()
    {
        return $this->belongsTo(SubConstructor::class);
    }

    public function activityLogs()
    {
        return $this->morphMany('Spatie\Activitylog\Models\Activity', 'causer');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
