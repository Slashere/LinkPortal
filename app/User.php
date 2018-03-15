<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Notifiable;

    protected $table = 'users';
    protected $guarded = [];

    public function role()
    {
        return $this->hasOne(Role::class, 'id','role_id');
    }

    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }

    public function hasAccess(array $permissions)
    {
            if ($this->role->hasAccess($permissions)) {
                return true;
        }
        return false;
    }

    public function isAdmin()
    {
            if ($this->role->name == 'Admin') {
                return true;
        }

        return false;
    }
}
