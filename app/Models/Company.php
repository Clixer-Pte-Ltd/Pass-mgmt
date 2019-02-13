<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use App\Models\Tenant;
use App\Models\SubConstructor;
use Carbon\Carbon;

class Company extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'companies';
    protected $primaryKey = 'uen';
    public $incrementing = false;
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['uen', 'type'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function scopeGetAllCompanies()
    {
        $companies = collect();
        $tenants = Tenant::all();
        $subcontructors = SubConstructor::all();
        foreach ($tenants as $tenant) {
            $companies->push($tenant);
        }
        foreach ($subcontructors as $subcontructor) {
            $companies->push($subcontructor);
        }
        return $companies;
    }

    public function scopeGetAllCompaniesWithin4Weeks()
    {
       $tenants = $this->scopeGetCompaniesWithin4Weeks(Tenant::query());
       $subConstructors = $this->scopeGetCompaniesWithin4Weeks(SubConstructor::query());
       foreach ($subConstructors as $subConstructor) {
           $tenants->push($subConstructor);
       }
       return $tenants;
    }

    public function scopeGetCompaniesWithin4Weeks($companyType)
    {
        return $companyType->where('tenancy_end_date', '<=', Carbon::now()->addWeeks(4))->get();
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function companyable()
    {
        return $this->morphTo(null, 'type', 'uen', 'uen');
    }

    public function accounts()
    {
        return $this->companyable->accounts;
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
