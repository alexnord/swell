<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\CrudTrait;
use Spatie\Permission\Traits\HasRoles;
use Backpack\Base\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
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
        'name', 'email', 'password', 'timezone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function report()
    {
        return $this->belongsTo('App\Report');
    }

    /**
    * Send the password reset notification.
    *
    * @param  string  $token
    * @return void
    */
    public function sendPasswordResetNotification($token)
    {
      $this->notify(new ResetPasswordNotification($token));
    }
}
