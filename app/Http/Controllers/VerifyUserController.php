<?php

namespace App\Http\Controllers;

use App\VerifyUser;
use App\Mail\VerifyMail;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Carbon;


class VerifyUserController extends Controller
{
    public function updateExpiredTime($id)
    {
        $user = User::findOrFail($id);

        $verifyUser = VerifyUser::where('user_id', '=', $id)->first();
        $verifyUser->expired_date = Carbon::now()->addHours(HOURS);
        $verifyUser->save();

        VerifyMail::sendAuthCode($user);
        return redirect(route('login'))->with('message', 'We have sent you an activation code, please check your email.');
    }
}
