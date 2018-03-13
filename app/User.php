<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use Authenticatable;

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
