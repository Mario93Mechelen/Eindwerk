<?php

namespace App\Http\Controllers;

use App\Friend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $friend_requests = Auth::user()->friends()->where('request_type','sent')->get();
        $friends = Auth::user()->friends()->where('request_type','friends')->get();
        return view('crossings.friends',compact('friend_requests','friends'));
    }

    public function accept(Request $request)
    {
        $myFriend = Friend::where('friend_sender', Auth::user()->id)->where('friend_receiver',$request->id)->first();
        $myFriend->request_type = 'friends';
        $myFriend->save();
        $yourFriend = Friend::where('friend_sender', $request->id)->where('friend_receiver',Auth::user()->id)->first();
        $yourFriend->request_type = 'friends';
        $yourFriend->save();
        return response()->json(['code' => 200,'me' => $myFriend,'you' => $yourFriend]);
    }

    public function deleteRequest(Request $request)
    {
        Friend::where('friend_sender', Auth::user()->id)->where('friend_receiver',$request->id)->delete();
        Friend::where('friend_sender', $request->id)->where('friend_receiver',Auth::user()->id)->delete();
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
     * @param  \App\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function show(Friend $friend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function edit(Friend $friend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Friend $friend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function destroy(Friend $friend)
    {
        //
    }
}
