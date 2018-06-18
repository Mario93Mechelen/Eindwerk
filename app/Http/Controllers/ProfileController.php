<?php

namespace App\Http\Controllers;

use App\BlockedUser;
use App\Comment;
use App\Crossing;
use App\Friend;
use App\Photo;
use App\Post;
use App\Profile;
use App\School;
use App\SchoolUser;
use App\Location;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Image;
use Pusher\Pusher;
use GuzzleHttp\Client;

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
        foreach(Auth::user()->myCrossings as $crossing) {
            if (!$crossing->isBlocked(Auth::user()->id) && !$crossing->blockedBy(Auth::user()->id)){
                $crossingLocations = $crossing->crossingLocationsPerUser(Auth::user()->id);
                foreach ($crossingLocations as $location) {
                    $crossinglocation = $location;
                }
                $crossingArr[$i] = ['user' => $crossing, 'location' => $crossinglocation, 'count' => $crossingLocations->count()];
                $i++;
            }
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

    public function filterStudents(Request $request)
    {
        $type = $request->type;
        $user = Auth::user();
        $location = Location::where('user_id',$user->id)->first();
        if($type == null) {
            $locations = Location::where('user_id', '!=', $user->id)->get();
        }elseif($type=='both'){
            $locations = Location::where('user_id', '!=', $user->id)->where('home_school',$user->home_school)->where('abroad_school',$user->abroad_school)->get();
        }elseif($type == 'home'){
            $locations = Location::where('user_id', '!=', $user->id)->where('home_school',$user->home_school)->get();
        }elseif($type== 'abroad'){
            $locations = Location::where('user_id', '!=', $user->id)->where('abroad_school',$user->abroad_school)->get();
        }
        $reqdistance = floatval($request->distance);
        if(Auth::user()->setting->distance == 'km'){
            $reqdistance = $reqdistance/1.609344;
        };
        if(!is_null($location) && !is_null($locations)) {
            $i = 0;
            $distance = [];
            foreach ($locations as $l) {
                if(!$l->user->isBlocked(Auth::user()->id) && !$l->user->blockedBy(Auth::user()->id)) {
                    $lon1 = $location->longitude;
                    $lat1 = $location->latitude;
                    $lon2 = $l->longitude;
                    $lat2 = $l->latitude;
                    $theta = $lon1 - $lon2;
                    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                    $dist = acos($dist);
                    $dist = rad2deg($dist);
                    $miles = $dist * 60 * 1.1515;

                    $kms = ($miles * 1.609344);

                    if (Auth::user()->setting == 'mile') {
                        $kms = number_format((float)$miles, 2, ',', '');
                        $distance[$i] = ['user' => $l->user, 'kms' => $miles];
                    } else {
                        $kms = number_format((float)$kms, 2, ',', '');
                        $distance[$i] = ['user' => $l->user, 'kms' => $kms];
                    };
                    if ((float)$kms <= (float)$reqdistance) {

                        $distance[$i] = ['user' => $l->user, 'kms' => $kms];
                        $i++;
                    }
                }
            };

            if(!empty($distance)){
                foreach($distance as $key => $row){
                    $kmsArr[$key] = $row['kms'];
                }

                array_multisort($kmsArr, SORT_ASC,$distance);
            }


        };

        return response()->json(['code' => 200, 'distance' => $distance, 'sent' => $reqdistance]);
    }

    public function updateInterests(Request $request)
    {
        $id = $request->id;
        if(Auth::user()->interests()->where('interests.id',$id)->first()){
            Auth::user()->interests()->detach($id);
        }else{
            Auth::user()->interests()->attach($id);
        }
        return response()->json(['code'=>200]);
    }

    public function getInstagramPhotos(Request $request)
    {
        if(count(Auth::user()->profile->photos)<10) {
            $count = count(Auth::user()->profile->photos);
            $client = new Client([
                'base_uri' => 'https://api.instagram.com',
                'timeout' => 2.0,
            ]);
            $res = $client->request('GET', '/v1/users/self/media/recent?access_token=' . Auth::user()->setting->access_token);
            $res = \GuzzleHttp\json_decode($res->getBody());
            foreach ($res->data as $data) {
                if(!Photo::where('path',$data->images->standard_resolution->url)->first()) {
                    $photo = new Photo();
                    $photo->path = $data->images->standard_resolution->url;
                    $photo->photoable_id = Auth::user()->profile->id;
                    $photo->photoable_type = Profile::class;
                    $photo->save();
                    $count++;
                    if ($count == 10) {
                        break;
                    }
                }
            }
        }
        return redirect()->back();
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
        $profile->path_cover = '/img/uploads/'.$filename;
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
            $path = public_path('img/uploads/'.$filename);
            $data = getimagesize($file);
            $width = $data[0];
            $height = $data[1];
            if($width>$height){
                Image::make($file->getRealPath())->crop($height,$height)->save($path);
            }else{
                Image::make($file->getRealPath())->crop($width,$width)->save($path);
            }

            //Storage::disk('public')->put($filename,file_get_contents($file->getRealPath()));
            //$file->save($filename);
        }elseif($request->remove_image=="on") {
            if(!is_null($filename) && $filename != '' && Storage::disk('public')->exists($filename)) {
                \Storage::disk('public')->delete($filename);
            }
            $filename = null;
        }

        $user = Auth::user();
        $user->avatar = '/img/uploads/'.$filename;
        $user->save();

        return redirect()->back();
    }

    public function updateProfile(Request $request)
    {
        $intro = $request->intro;
        $home = $request->home;
        $study = $request->study;
        $school_home = $request->school_home;
        $school_abroad = $request->school_abroad;
        $gender = $request->gender;
        $birthdate = $request->birthdate;
        $user = User::find(Auth::user()->id);
        //$user->update(['intro'=>$intro,'home'=>$home,'study'=>$study,'gender'=>$gender,'home_school'=>$school_home,'abroad_school'=>$school_abroad,'birthdate'=>$birthdate]);
        $user->intro = $intro;
        $user->home = $home;
        $user->study = $study;
        $user->home_school = $school_home;
        $user->abroad_school  = $school_abroad;
        if($school_abroad != ''){
            if(!School::where('name',$school_abroad)->first()) {
                $school = new School();
                $school->name = $school_abroad;
                $school->save();
                $user->school_id = $school->id;
            }else{
                $id = School::where('name',$school_abroad)->first()->id;
                $user->school_id = $id;

            }
        }
        $user->gender = $gender;
        $user->birthday = $birthdate;
        $user->save();
        return response()->json(['code' => 200]);
    }

    public function sendFriendRequest(Request $request)
    {
        $friendSent = Friend::where('friend_sender', Auth::user()->id)->where('friend_receiver',$request->id)->where('request_type','pending')->first();
        $friend = Friend::where('friend_sender', Auth::user()->id)->where('friend_receiver',$request->id)->where('request_type','friends')->first();
        if(!$friend && !$friendSent) {
            if(Friend::where('friend_sender', Auth::user()->id)->where('friend_receiver',$request->id)->where('request_type','sent')->first()){
                $friendGet = Friend::where('friend_sender', Auth::user()->id)->where('friend_receiver',$request->id)->where('request_type','sent')->first();
                $friendGet2 = Friend::where('friend_sender', $request->id)->where('friend_receiver',Auth::user()->id)->where('request_type','pending')->first();
                $friendGet->request_type = 'friends';
                $friendGet->save();
                $friendGet2->request_type = 'friends';
                $friendGet2->save();
                $buttonText = 'friends';
            }else {
                $id = $request->id;
                $friend = new Friend();
                $friend->friend_sender = Auth::user()->id;
                $friend->friend_receiver = $id;
                $friend->request_type = 'pending';
                $friend->save();
                $id = $request->id;
                $friend = new Friend();
                $friend->friend_sender = $id;
                $friend->friend_receiver = Auth::user()->id;
                $friend->request_type = 'sent';
                $friend->save();
                $buttonText = 'request sent';

                $this->makeEventObject()->trigger('friend_request' . $id, 'new-request', ['data' => ['request' => 'sent']]);
            }
        }else{
            if($friend){
                Friend::where('friend_sender', Auth::user()->id)->where('friend_receiver',$request->id)->where('request_type','friends')->delete();
                Friend::where('friend_sender', $request->id)->where('friend_receiver',Auth::user()->id)->where('request_type','friends')->delete();
            };
            if($friendSent){
                Friend::where('friend_sender', Auth::user()->id)->where('friend_receiver',$request->id)->where('request_type','pending')->delete();
                Friend::where('friend_sender', $request->id)->where('friend_receiver',Auth::user()->id)->where('request_type','sent')->delete();
            };
            $buttonText = 'add friend';
        };

        return response()->json(['code' => 200, 'text' => $buttonText]);
    }

    private function makeEventObject()
    {
        $options = array(
            'cluster' => 'eu', // Cluster
            'encrypted' => true,
        );

        return new Pusher(
            env('PUSHER_APP_KEY'), // public key
            env('PUSHER_APP_SECRET'), // Secret
            env('PUSHER_APP_ID'), // App_id
            $options
        );
    }

    public function blockUser(Request $request)
    {
        $id = $request->id;
        $blockedUser = new BlockedUser();
        $blockedUser->block_sender = Auth::user()->id;
        $blockedUser->block_receiver = $id;
        $blockedUser->save();
        return response()->json(['code' => 200]);
    }

    public function deleteBlockedUser(Request $request)
    {
        $id = $request->id;
        BlockedUser::where('block_sender',Auth::user()->id)->where('block_receiver', $id)->first()->delete();
        return response()->json(['code' => 200, 'id' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if($user->isBlocked(Auth::user()->id) || $user->blockedBy(Auth::user()->id)){
            return redirect('/');
        };
        /*if($user->blockedBy(Auth::user()->id)){
          dd($user);
        };*/
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

    public function school()
    {
        $post = Post::where('body', 'new post by ' . Auth::user()->id)->first();
        if ($post){
            foreach ($post->photos as $photo) {
                \Storage::disk('public')->delete($photo->path);
                $photo->delete();
            };
        $post->delete();
        }
        return view('school.school');
    }

    public function postComment(Request $request)
    {
        $id = $request->postID;
        $text = $request->comment;
        $comment = new Comment();
        $comment->body = $text;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $id;
        $comment->save();
        return redirect()->back();
    }

    public function addPost(Request $request)
    {
        $id = intval($request->id);
        $type = $request->type;
        $body = $request->body;
        $post = Post::where('body','new post by '.Auth::user()->id)->first();
        if($type=='student'){
            $post->body = $body;
            $post->user_id = Auth::user()->id;
            $post->school_id = $id;
            $post->type = 'student';
        }else{
            $post->body = $body;
            $post->user_id = $id;
            $post->school_id = $id;
            $post->type = 'school';
        }
        $post->save();
        return response()->json(['code' => 200,'id' => $post->id]);
    }
}
