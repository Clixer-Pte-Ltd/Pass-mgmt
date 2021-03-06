<?php

namespace App\Models;

use App\User;
use Illuminate\Support\Collection;
use Tightenco\Parental\HasParentModel;
use App\Traits\LogsActivity;
use Carbon\Carbon;
use App\Models\Notification;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class BackpackUser extends User
{
    use HasParentModel;
    use LogsActivity;

    const FIELD_LOG = [
        'name', 'email', 'phone'
    ];
    public $routeName = 'user';
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
        return is_null($this->tenant) && is_null($this->subConstructor) && !$this->tenantsOfAs->count() ? false : true; // false if user is admin or airport pass team
    }

    public function getCompany()
    {
        $companies = collect([$this->tenant]);
        $tenantsOfAss= $this->tenantsOfAs;
        foreach ($tenantsOfAss as $tenant) {
            $companies->push($tenant);
        }
        if ($this->tenant) {
            $this->tenant->subContructors->each(function($item, $key) use ($companies) {
                $companies->push($item);
            });
        }

        if ($this->tenantsOfAs->count()) {
            $this->tenantsOfAs->each(function($tenant, $key) use ($companies){
                $tenant->subContructors->each(function($item, $k) use ($companies) {
                    $companies->push($item);
                });
            });

        }
        $companies = $companies->unique()->filter();
        return isset($companies) ? $companies : null;
    }

    public function tenants()
    {
        $companies = collect([$this->tenant]);
        $tenantsOfAss= $this->tenantsOfAs;
        foreach ($tenantsOfAss as $tenant) {
            $companies->push($tenant);
        }
        return $companies->unique()->filter();
    }

    public function getAllTenants()
    {
        $companies = $this->getCompany();
        if ($companies) {
            $tenants = collect([]);
            $companies->each(function($item, $key) use ($tenants) {
                if ($item instanceof Tenant) {
                    $tenants->push($item);
                }
            });
            return $tenants;
        }
    }

    /**
     * @return Collection
     */
    public function getSubConstructors()
    {
        $companies = $this->getCompany();
        if ($companies) {
            $subs = collect([]);
            $companies->each(function($item, $key) use ($subs) {
                if ($item instanceof SubConstructor) {
                    $subs->push($item);
                }
            });
            return $subs;
        }
    }

    public function getNotifications($type)
    {
        return $this->notifications->where('type', $type);
    }

    public function detachNotification($name)
    {
        $notification = Notification::getByName($name);
        return $notification ? $this->notifications()->detach($notification->id) : false;
    }

    public function checkRestrictionPassField()
    {
        return backpack_user()->hasAnyRole([COMPANY_CO_ROLE, COMPANY_AS_ROLE]) && !in_array(\Route::current()->getName(),
                ["crud.pass-holder.edit", "crud.tenant-pass-holder.index"]);
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

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'user_notification');
    }

    public function tenantsOfAs()
    {
        return $this->belongsToMany(Tenant::class, 'user_tenants');
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
