<?php

namespace App\Http\Controllers\Auth;

use App\Mail\ConfirmationMail;
use Illuminate\Support\Facades\Mail;
use App\Setting;
use App\User;
use App\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function index()
    {
        return view('auth.signup');
    }

    public function index2()
    {
        return view('auth.signup-step2');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function register(Request $request)
    {
        $user = new User();
        if($request->password != $request->password_repeat){
            return redirect()->back()->with('status','passwords do not match');
        }else{
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->first_name = $request->firstname;
            $user->last_name = $request->lastname;
            $user->token = str_random(16);
            $user->avatar = "/img/Default_pictures_Man.png";
            $user->save();
            $setting = new Setting();
            $setting->user_id = $user->id;
            $setting->save();
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->save();
            $objDemo = new \stdClass();
            $objDemo->receiver = $user->first_name;
            $objDemo->token = $user->token;
            $objDemo->sender = 'Semestr Team';

            Mail::to($user->email)->send(new ConfirmationMail($objDemo));
            return redirect('/login')->with(['message'=>'we have sent you a confirmation mail']);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
