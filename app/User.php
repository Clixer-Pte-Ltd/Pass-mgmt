<?php

namespace App;

use App\Events\UserCreated;
use Backpack\CRUD\CrudTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use CrudTrait;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'google2fa_secret', 'phone', 'tenant_id', 'sub_constructor_id', 'is_imported',
        'token', 'last_modify_password_at', 'change_first_pass_done', 'first_password', 'send_info_email_log'
    ];
    protected $dates = ['last_modify_password_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'google2fa_secret'
    ];

    public function setGoogle2faSecretAttribute($value)
    {
        $this->attributes['google2fa_secret'] = encrypt($value);
    }

    protected $dispatchesEvents = [
        'created' => UserCreated::class,
    ];

    public function getGoogle2faSecretAttribute($value)
    {
        if (!$value) {
            return $value;
        }
        return decrypt($value);
    }

    public function setPasswordAttribute($pass){
        $this->attributes['password'] = bcrypt($pass);
    }
}
