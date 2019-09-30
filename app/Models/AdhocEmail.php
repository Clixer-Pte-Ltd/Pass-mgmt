<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class AdhocEmail extends Model
{
    use CrudTrait;
    use LogsActivity;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    const FIELD_LOG = [
        'subject', 'body'
    ];
    public $routeName = 'adhoc-email';
    protected $table = 'adhoc_emails';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['subject', 'body'];
    protected static $logFillable = true;
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function scopeSearchByDestinations($query, $column, $searchTerm)
    {
        return $query->orWhereHas('destinations', function ($q) use ($column, $searchTerm) {
            $q->where('name', 'like', '%'.$searchTerm.'%');
        });
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function destinations()
    {
        return $this->belongsToMany(Company::class, 'adhoc_email_destination', 'adhoc_email_id', 'company_uen');
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
