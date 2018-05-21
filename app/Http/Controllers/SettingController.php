<?php

namespace App\Http\Controllers;

use App\Setting;
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
