<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Location;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $location = Location::where('user_id',$user->id)->first();
        $locations = Location::where('user_id','!=', $user->id)->get();
        if(!is_null($location) && !is_null($locations)) {
            $i = 0;
            $distance = [];
            foreach ($locations as $l) {
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

                $kms = number_format((float)$kms, 2, ',','');
                $miles = number_format((float)$miles, 2, ',','');

                if(Auth::user()->setting == 'mile'){
                    $distance[$i] = ['user' => $l->user, 'kms' => $miles];
                }else{
                    $distance[$i] = ['user' => $l->user, 'kms' => $kms];
                }

                $i++;
            }

            if(!empty($distance)){
                foreach($distance as $key => $row){
                    $kmsArr[$key] = $row['kms'];
                }

                array_multisort($kmsArr, SORT_ASC,$distance);
            }
        }

        return view('home.home', compact('user','location', 'distance'));
    }

    public function filterDistance(Request $request){
        $user = Auth::user();
        $location = Location::where('user_id',$user->id)->first();
        $locations = Location::where('user_id','!=', $user->id)->get();
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
