<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getLocation(Request $request)
    {
        $client = new Client();
        $res = $client->request('POST', 'https://www.googleapis.com/geolocation/v1/geolocate?key='.$request->key);
        $res = \GuzzleHttp\json_decode($res->getBody());
        return response()->json(['code'=>200, "res" => $res]);
        //https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyBvs7EHp5iJ5aaCe-k2DodKcTyzFtbqrdw
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $myLocation = Location::where('user_id',Auth::user()->id)->first();
        if($request->amount<1){
            $client = new Client();
            $res = $client->request('GET','http://maps.googleapis.com/maps/api/geocode/json', ['query' => ['sensor' => 'false', 'language' => 'nl', 'latlng' => $latitude.','.$longitude]]);
            //sensor=false&language=nl&latlng='.$latitude.','.$longitude
            $res = \GuzzleHttp\json_decode($res->getBody());
            if($res->results) {
                $city = $res->results[0]->address_components[2]->long_name;
            }else{
                if($myLocation){
                    $city = $myLocation->city;
                    $res = ['results' => [['address_components' => [['first' => 'first'], ['first' => 'first'], ['long_name' => $city]]]], ['array2' => "self constructed"]];
                }else {
                    $city = "unknown";
                    $res = ['results' => [['address_components' => [['first' => 'first'], ['first' => 'first'], ['long_name' => $city]]]], ['array2' => "self constructed"]];
                }
            }
        }else{
            if(Location::where('user_id',Auth::user()->id)->first()){
                $city = $myLocation->city;
                $res = ['results'=>[['address_components'=>[['first'=>'first'],['first'=>'first'],['long_name' => $city]]]],['array2' =>"self constructed"]];
            }else{
                $city = "unknown";
                $res = ['results'=>[['address_components'=>[['first'=>'first'],['first'=>'first'],['long_name' => $city]]]],['array2' =>"self constructed"]];
            }
        }
        if($myLocation){
            if($city != 'unknown') {
                $myLocation->update(['latitude' => $latitude, 'longitude' => $longitude, 'city' => $city]);
            }else{
                $myLocation->update(['latitude' => $latitude, 'longitude' => $longitude]);
            }
        }else {
            $location = new Location();
            $location->longitude = $longitude;
            $location->latitude = $latitude;
            $location->city = $city;
            $location->user_id = Auth::user()->id;
            $location->save();
        }
        return response()->json(['code'=>200, "res" => $res]);
        //http://maps.googleapis.com/maps/api/geocode/json?sensor=false&language=en&latlng=51.0350601,4.4531024
    }


    public function checkDistances()
    {

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
