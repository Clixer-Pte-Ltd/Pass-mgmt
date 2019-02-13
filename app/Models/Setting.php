<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Setting extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'settings';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function getSmtpConfig()
    {
        return static::whereIn('key', [
            SMTP_HOST, SMTP_PORT, SMTP_USERNAME, SMTP_PASSWORD, SMTP_ENCRYPTION
        ])->get();
    }
    public static function getCronTime($type, $data)
    {
        $time = isset($data['time']) ? explode(':', $data['time']) : [0, 0];
        switch ($type) {
            case 'every-minutes':
                return '* * * * *';
                break;
            case 'daily':
                return $time[1] . ' ' . $time[0] . ' * * *';
                break;
            case 'weekly':
                return $time[1] . ' ' . $time[0] . ' * *' . ' ' . $data['day-of-week'];
                break;
            case 'monthly':
                return $time[1] . ' ' . $time[0] . ' ' . $data['day-of-month'] . ' * *';
                break;
            case 'yearly':
                return $time[1] . ' ' . $time[0] . ' ' . $data['day-of-month'] . ' ' . $data['month'] . ' *';
                break;
            default:
                return '0 0 1 * *';
        }
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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
