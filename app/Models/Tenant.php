<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\BackpackUser as User;
use App\Models\Company;

class Tenant extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tenants';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'uen', 'tenancy_start_date', 'tenancy_end_date', 'role_id', 'status'];
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function accounts()
    {
        return $this->hasMany(User::class);
    }

    public function subContructors()
    {
        return $this->hasMany(SubConstructor::class);
    }

    public function passHolders()
    {
        return $this->hasMany(PassHolder::class, 'company_uen', 'uen');
    }

    public function company()
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
