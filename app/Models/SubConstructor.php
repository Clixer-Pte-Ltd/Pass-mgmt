<?php

namespace App\Models;

use App\Models\BackpackUser as User;
use App\Models\Company;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class SubConstructor extends Model
{
    use CrudTrait;
    use LogsActivity;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    const FIELD_LOG = [
        'name', 'uen'
    ];
    public $routeName = 'sub-constructor';
    protected $table = 'sub_constructors';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'uen', 'tenancy_start_date', 'tenancy_end_date', 'role_id', 'tenant_id', 'status'];
    protected static $logFillable = true;
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function hasAccount($account)
    {
        return $this->accounts->contains($account);
    }

    public function getAllAccounts()
    {
        return $this->accounts;
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function accounts()
    {
        return $this->hasMany(User::class);
    }

    public function passHolders()
    {
        return $this->hasMany(PassHolder::class, 'company_uen', 'uen');
    }

    public function company()
    {
        return $this->morphOne(Company::class, 'companyable', 'type', 'uen', 'uen');
    }

    public function companyExpire()
    {
        return $this->morphOne(Company::class, 'companyable', 'type', 'uen', 'uen');
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
