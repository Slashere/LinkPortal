<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use Authenticatable;

    protected $table='users';
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users');
    }

    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }

    public function hasAccess(array $permissions)
    {
        foreach($this->roles as $role){
            if($role->hasAccess($permissions)){
                return true;
            }
        }
        return false;
    }
}
