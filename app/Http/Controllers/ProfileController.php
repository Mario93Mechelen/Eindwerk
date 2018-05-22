<?php

namespace App\Http\Controllers;

use App\Crossing;
use App\Friend;
use Illuminate\Support\Facades\Storage;
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
        $crossingArr = [];
        $i=0;
        foreach(Auth::user()->myCrossings as $crossing){
            $crossingLocations = $crossing->crossingLocationsPerUser(Auth::user()->id);
            foreach($crossingLocations as $location){
                $crossinglocation = $location;
            }
            $crossingArr[$i] = ['user'=>$crossing,'location'=>$crossinglocation,'count' => $crossingLocations->count()];
            $i++;
        }

        if(!empty($crossingArr)){
            foreach($crossingArr as $key => $row){
                $countArr[$key] = $row['count'];
            }

            array_multisort($countArr, SORT_DESC,$crossingArr);
        }

        if(!Auth::user()->myCrossings()->where('seen',0)->get()->isEmpty()){
            Crossing::where('crosser_id',Auth::user()->id)->where('seen', 0)->update(['seen' =>true]);
        }
        return view('crossings.overview',compact('crossingArr'));
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

    public function updateCover(Request $request)
    {
        $filename = Auth::user()->profile->path_cover;
        if ($request->cover_image) {
            if(!is_null($filename) && $filename != '' && Storage::disk('public')->exists($filename)) {
                \Storage::disk('public')->delete($filename);
            }

            $file = $request->file('cover_image');
            $originalName = str_replace(' ', '-', str_replace('(', '', str_replace(')', '', $file->getClientOriginalName())));
            $filename = time().$originalName;
            Storage::disk('public')->put($filename, file_get_contents($file->getRealPath()));
        }elseif($request->remove_image=="on") {
            if(!is_null($filename) && $filename != '' && Storage::disk('public')->exists($filename)) {
                \Storage::disk('public')->delete($filename);
            }
            $filename = null;
        }

        $profile = Auth::user()->profile;
        $profile->path_cover = $filename;
        $profile->save();

        return redirect()->back();

    }

    public function updateProfilepic(Request $request)
    {
        $filename = Auth::user()->avatar;
        if (strpos($filename, 'http') !== false) {
            $filename = null;
        }
        if ($request->profile_image) {
            if(!is_null($filename) && $filename != '' && Storage::disk('public')->exists($filename)) {
                \Storage::disk('public')->delete($filename);
            }

            $file = $request->file('profile_image');
            $originalName = str_replace(' ', '-', str_replace('(', '', str_replace(')', '', $file->getClientOriginalName())));
            $filename = time().$originalName;
            Storage::disk('public')->put($filename, file_get_contents($file->getRealPath()));
        }elseif($request->remove_image=="on") {
            if(!is_null($filename) && $filename != '' && Storage::disk('public')->exists($filename)) {
                \Storage::disk('public')->delete($filename);
            }
            $filename = null;
        }

        $user = Auth::user();
        $user->avatar = $filename;
        $user->save();

        return redirect()->back();
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
        if($user->id != Auth::user()->id) {
            if(Crossing::where('crosser_id', Auth::user()->id)->where('crossed_id', $user->id)->first()) {
                $crossingLocations = Crossing::where('crosser_id', Auth::user()->id)->where('crossed_id', $user->id)->first()->crossingLocations;
            }
        }
        return view('crossings.userprofile',compact('user','crossingLocations'));
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

    public function settings() {
        return view('home.settings');
    }
}
