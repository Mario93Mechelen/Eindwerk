<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;

use Socialite;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider(){
        return Socialite::driver('facebook')->scopes(['user_birthday'])->redirect();
    }

    public function handleProviderCallback(){
        $user = Socialite::driver('facebook')->fields(['languages', 'first_name', 'last_name', 'email', 'gender', 'birthday'])->user();
        if(!User::where('email',$user->user["email"])->first()) {
            $appUser = new User();
            $appUser->first_name = $user->user["first_name"];
            $appUser->last_name = $user->user["last_name"];
            $appUser->gender = $user->user["gender"];
            $appUser->birthday = \Carbon\Carbon::parse($user->user["birthday"]);
            $appUser->email = $user->user["email"];
            $appUser->token = $user->token;
            $appUser->save();
        }else{
            $appUser = User::where('email',$user->user["email"])->first();
        }
        Auth::login($appUser);
        return redirect('/home');
    }
}
