<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use App\Models\Tenant;
use App\Models\SubContructor;

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
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function companyable()
    {
        return $this->morphTo(null, 'type', 'uen', 'uen');
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
