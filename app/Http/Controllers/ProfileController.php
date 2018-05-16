<?php

namespace App\Http\Controllers;

use App\Friend;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('crossings.overview');
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

    public function sendFriendRequest(Request $request)
    {
        $friendSent = Friend::where('friend_sender', Auth::user()->id)->where('friend_receiver',$request->id)->where('request_type','sent')->first();
        $friend = Friend::where('friend_sender', Auth::user()->id)->where('friend_receiver',$request->id)->where('request_type','friends')->first();
        if(!$friend && !$friendSent) {
            $id = $request->id;
            $friend = new Friend();
            $friend->friend_sender = Auth::user()->id;
            $friend->friend_receiver = $id;
            $friend->request_type = 'sent';
            $friend->save();
            $id = $request->id;
            $friend = new Friend();
            $friend->friend_sender = $id;
            $friend->friend_receiver = Auth::user()->id;
            $friend->request_type = 'pending';
            $friend->save();
            $buttonText = 'request sent';
        }else{
            if($friend){
                Friend::where('friend_sender', Auth::user()->id)->where('friend_receiver',$request->id)->where('request_type','friends')->delete();
                Friend::where('friend_sender', $request->id)->where('friend_receiver',Auth::user()->id)->where('request_type','friends')->delete();
            };
            if($friendSent){
                Friend::where('friend_sender', Auth::user()->id)->where('friend_receiver',$request->id)->where('request_type','sent')->delete();
                Friend::where('friend_sender', $request->id)->where('friend_receiver',Auth::user()->id)->where('request_type','pending')->delete();
            };
            $buttonText = 'add friend';
        };

        return response()->json(['code' => 200, 'text' => $buttonText]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //Als je surft naar de link /user/eigen-user-id zou je deze link ook wel moeten kunnen zien
        return view('crossings.userprofile',compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //gebruik hiervoor de globale $myUser variabele in de view
        return view('crossings.userprofile');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
