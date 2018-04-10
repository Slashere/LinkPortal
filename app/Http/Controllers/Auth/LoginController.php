<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyMail;
use App\VerifyUser;
use Illuminate\Support\Facades\Config;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function authenticated(Request $request, User $user)
    {
        if (!$user->verified) {
            $this->guard()->logout();

            $verifyUser = VerifyUser::where('user_id', '=', $user->id)->first();

            if ($verifyUser == null) {

                VerifyUser::create([
                    'user_id' => $user->id,
                    'token' => str_random(40),
                    'expired_date' => Carbon::now()->addHours(Config::get('constants.options'))
                ]);

                VerifyMail::sendAuthCode($user);
                return back()->with('message', 'You need to confirm your account. We have sent you an activation code, please check your email.');
            } else {
                return view('auth.code',compact('user'));
            }

        }
        return redirect()->intended($this->redirectPath());
    }

}
