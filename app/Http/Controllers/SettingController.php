<?php

namespace App\Http\Controllers;

use App\Setting;
use GuzzleHttp\Client;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function redirectToProviderTwitter(){
        return Socialite::driver('twitter')->redirect();
    }

    public function handleProviderCallbackTwitter(){
        $user = Socialite::driver('twitter')->user();
        $setting = Auth::user()->setting;
        $setting->twitter = 'https://twitter.com/'.$user->nickname;
        $setting->save();
        return redirect('/profile/settings');
    }

    public function redirectToProviderInstagram(){
        return redirect('https://api.instagram.com/oauth/authorize/?client_id='.env("INSTAGRAM_CLIENT_ID").'&redirect_uri='.env("INSTAGRAM_REDIRECT_URI").'&response_type=code');
    }

    public function handleProviderCallbackInstagram(){
        if(request()->has('code')){
            $code= request()->code;
            $client = new Client([
                'base_uri' => 'https://api.instagram.com',
                'timeout' => 2.0,
            ]);
            $params =[
                'form_params' => [
                    'client_id' =>  env("INSTAGRAM_CLIENT_ID"),
                    'client_secret' => env("INSTAGRAM_CLIENT_SECRET"),
                    'code' => $code,
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => env("INSTAGRAM_REDIRECT_URI"),
                ]
            ];
            $res = $client->request('POST','/oauth/access_token',$params);
            $res = \GuzzleHttp\json_decode($res->getBody());
            $setting = Auth::user()->setting;
            $setting->instagram = 'https://www.instagram.com/'.$res->user->username;
            $setting->save();
        }
        return redirect('/profile/settings');
    }

    public function disconnectSocialMedia(Request $request)
    {
        $social = $request->social;
        $setting = Auth::user()->setting;
        if($social == 'facebook'){
            $setting->facebook = '';
        }elseif($social=='twitter'){
            $setting->twitter = '';
        }else{
            $setting->instagram = '';
        }
        $setting->save();
        return response()->json(['code' => 200]);
    }

    public function updateEmail(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->email = $request->email;
        $user->save();

        return response()->json(['code' => 200]);
    }

    public function updatePassword(Request $request)
    {
        $oldp = $request->oldp;
        $newp = $request->newp;
        $user = User::find(Auth::user()->id);
        if(Hash::check($oldp,$user->password)){
            $user->password = Hash::make($newp);
            $user->save();
            return response()->json(['code' => 200]);
        }
    }

    public function updateEmailNotifications(Request $request)
    {
        $id = $request->id;
        $val = $request->val;
        $setting = Setting::where('user_id', Auth::user()->id)->first();
        if($id=='settings-email_message'){
            $setting->email_messages = ($val == 'true') ? 1 : 0;
            $setting->save();
        }elseif($id=='settings-email_friends'){
            $setting->email_friends = ($val == 'true') ? 1 : 0;
            $setting->save();
        }else{
            $setting->email_groups = ($val == 'true') ? 1 : 0;
            $setting->save();
        }
        return response()->json(['code' => 200]);
    }

    public function updateDistance(Request $request)
    {
        $distance = $request->distance;
        $setting = Setting::where('user_id', Auth::user()->id)->first();
        if($distance == "kilometers"){
            $setting->distance = 'km';
            $setting->save();
        }else{
            $setting->distance = 'mile';
            $setting->save();
        }
        return response()->json(['code' => 200]);
    }

    public function deleteAllInfo()
    {
        if(Auth::user()->conversation){
            $conversations = Auth::user()->conversation;
            foreach($conversations as $conversation){
                $conversation->delete();
            }
        }
        User::find(Auth::user()->id)->delete();
        Auth::logout();
        return response()->json(['code' => 200]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
