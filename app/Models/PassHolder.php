<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use App\Events\PassHolderCreated;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class PassHolder extends Model
{
    use CrudTrait;
    use LogsActivity;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'pass_holders';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['applicant_name', 'nric', 'pass_expiry_date', 'country_id', 'company_uen', 'ru_name', 'ru_email', 'as_name', 'as_email', 'status'];
    protected static $logFillable = true;
    // protected $hidden = [];
    // protected $dates = [];

    protected $dispatchesEvents = [
        'created' => PassHolderCreated::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_uen', 'uen');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'pass_holder_zone');
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
    public function getNricAttribute($value)
    {
        if (backpack_user()->hasAnyRole([CAG_VIEWER_ROLE, COMPANY_VIEWER_ROLE]) && $value) {
            return substr_replace($value,"***",0, strlen($value)-4);
        }
        return $value;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
