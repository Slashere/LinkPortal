<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'users';
    protected $guarded = [];


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

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

    public function getJWTCustomClaims(): array {
        return [];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
}
