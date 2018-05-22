<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Setting;
use App\Profile;

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
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
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

    public function login(Request $request)
    {
        if(User::where('email', $request->email)->first()){
            $user = User::where('email', $request->email)->first();
            if(Hash::check($request->password,$user->password)){
                Auth::login($user, true);
                return redirect('/');
            }else{
                return Redirect::back()->withErrors(['incorrect password lol']);
            }
        }else{
            return Redirect::back()->withErrors(['incorrect email lol']);
        }
    }

    public function handleProviderCallbackFacebook(){
        $user = Socialite::driver('facebook')->fields(['languages', 'first_name', 'last_name', 'email', 'gender', 'birthday','link'])->user();
        if(!User::where('email',$user->user["email"])->first()) {
            $appUser = new User();
            $appUser->first_name = $user->user["first_name"];
            $appUser->last_name = $user->user["last_name"];
            $appUser->gender = isset($user->user["gender"]) ? $user->user["gender"] : 'other';
            $appUser->birthday = isset($user->user["birthday"]) ? \Carbon\Carbon::parse($user->user["birthday"]) : null;
            $appUser->email = $user->user["email"];
            $appUser->avatar = str_replace("normal","large",$user->avatar);
            $appUser->token = $user->token;
            $appUser->save();
            $setting = new Setting();
            $setting->user_id = $appUser->id;
            $setting->facebook = $user->profileUrl;
            $setting->save();
            $profile = new Profile();
            $profile->user_id = $appUser->id;
            $profile->save();

        }else{
            $appUser = User::where('email',$user->user["email"])->first();
        }
        Auth::login($appUser,true);
        return redirect('/');
    }
}
