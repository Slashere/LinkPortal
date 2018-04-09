<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\User;
use Gate;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use Validator;



class UserController extends Controller
{
    private $userservice;

    public function __construct(UserService $userservice)
    {
        $this->userservice = $userservice;
    }

    public function show(User $user)
    {
        if (Gate::allows('update-user-status-and-role')) {
            return $user;
        }

        if (Auth::guard('api')->user()) {
            if (Auth::guard('api')->user()->id == $user->id) {
                return $user;
            } elseif (Auth::guard('api')->user()->isAdmin()){
                return $user->only(['id','name','surname','role_id']);
            }
        }
        return $user->only(['id','name','surname','role_id']);
    }

    public function store(Request $request)
    {
        return $this->userservice->create($request);
    }

    public function update(User $user, Request $request)
    {

       return $this->userservice->update($user, $request);

    }

    public function destroy(User $user)
    {
        $this->userservice->destroy($user);
    }

}
