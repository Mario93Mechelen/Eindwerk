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

    public function index()
    {
        return view('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function redirectToProviderFacebook(){
        return Socialite::driver('facebook')->scopes(['user_birthday'])->redirect();
    }

    public function redirectToProviderTwitter(){
        return Socialite::driver('twitter')->redirect();
    }

    public function redirectToProviderGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallbackFacebook(){
        $user = Socialite::driver('facebook')->fields(['languages', 'first_name', 'last_name', 'email', 'gender', 'birthday'])->user();
        if(!User::where('email',$user->user["email"])->where('social_type','facebook')->first()) {
            $appUser = new User();
            $appUser->first_name = $user->user["first_name"];
            $appUser->last_name = $user->user["last_name"];
            $appUser->gender = $user->user["gender"];
            $appUser->birthday = \Carbon\Carbon::parse($user->user["birthday"]);
            $appUser->email = $user->user["email"];
            $appUser->token = $user->token;
            $appUser->social_type = 'facebook';
            $appUser->save();
        }else{
            $appUser = User::where('email',$user->user["email"])->where('social_type','facebook')->first();
        }
        Auth::login($appUser);
        return redirect('/home');
    }

    public function handleProviderCallbackTwitter(){
        $user = Socialite::driver('twitter')->user();
        if(!User::where('token',$user->token)->first()) {
            if(strpos($user->name,' ')) {
                $indexSpace = strpos($user->name, ' ');
                $length = strlen($user->name);
                $first_name = substr($user->name,0,($indexSpace+1));
                $last_name = substr($user->name,($indexSpace+1),$length);
            }else{
                $first_name = $user->name;
                $last_name = $user->name;
            }
            $appUser = new User();
            $appUser->first_name = $first_name;
            $appUser->last_name = $last_name;
            $appUser->token = $user->token;
            $appUser->social_type = 'twitter';
            $appUser->save();
        }else{
            $appUser = User::where('token',$user->token)->first();
        }
        Auth::login($appUser);
        return redirect('/home');
    }

    public function handleProviderCallbackGoogle(){
        $user = Socialite::driver('google')->user();
        dd($user);
        /*if(!User::where('token',$user->token)->first()) {
            if(strpos($user->name,' ')) {
                $indexSpace = strpos($user->name, ' ');
                $length = strlen($user->name);
                $first_name = substr($user->name,0,($indexSpace+1));
                $last_name = substr($user->name,($indexSpace+1),$length);
            }else{
                $first_name = $user->name;
                $last_name = $user->name;
            }
            $appUser = new User();
            $appUser->first_name = $first_name;
            $appUser->last_name = $last_name;
            $appUser->token = $user->token;
            $appUser->save();
        }else{
            $appUser = User::where('token',$user->token)->first();
        }
        Auth::login($appUser);
        return redirect('/home');*/
    }
}
