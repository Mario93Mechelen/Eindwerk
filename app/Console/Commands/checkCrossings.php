<?php

namespace App\Console\Commands;

use App\CrossingLocation;
use Illuminate\Console\Command;
use App\User;
use App\Crossing;
use App\Location;
use Illuminate\Support\Facades\Log;

class checkCrossings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:crossings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will check if you crossed people';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $locations = Location::all();
        foreach($locations as $location) {
            if($location->user->isOnline()) {
                $otherLocations = Location::where('user_id', '!=', $location->user_id)->get();
                foreach ($otherLocations as $otherLocation) {
                    if($otherLocation->user->isOnline()) {
                        $lon1 = $location->longitude;
                        $lat1 = $location->latitude;
                        $lon2 = $otherLocation->longitude;
                        $lat2 = $otherLocation->latitude;
                        $theta = $lon1 - $lon2;
                        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                        $dist = acos($dist);
                        $dist = rad2deg($dist);
                        $miles = $dist * 60 * 1.1515;

                        $kms = ($miles * 1.609344);

                        //are the users closer than 250m
                        if ($kms <= 0.25) {
                            $this->line('we have a crossing');
                            //ladies and gents, we've got a crossing right here
                            //is there already a crossing registered?
                            if (!Crossing::where('crosser_id', $location->user_id)->where('crossed_id', $otherLocation->user_id)->first() || !Crossing::where('crosser_id', $otherLocation->user_id)->where('crossed_id', $location->user_id)->first()) {
                                $crossing = new Crossing();
                                $crossing->crosser_id = $location->user_id;
                                $crossing->crossed_id = $otherLocation->user_id;
                                $crossing->meeting = true;
                                $crossing->save();
                                $crossing_location = new CrossingLocation();
                                $crossing_location->crossing_id = $crossing->id;
                                $crossing_location->latitude = $location->latitude;
                                $crossing_location->longitude = $location->longitude;
                                $crossing_location->save();
                                //update the registered crossing and add a new crossing_location
                            }else{
                                $crossing = Crossing::where('crosser_id', $location->user_id)->where('crossed_id', $otherLocation->user_id)->first();
                                if($crossing->meeting == false) {
                                    $crossing->meeting = true;
                                    $crossing->save();
                                    $crossing_location = new CrossingLocation();
                                    $crossing_location->crossing_id = $crossing->id;
                                    $crossing_location->latitude = $location->latitude;
                                    $crossing_location->longitude = $location->longitude;
                                    $crossing_location->save();
                                }
                            }
                            //if there is an existing crossing, update it to be false when users are far away from each other
                        }else{
                            if(Crossing::where('crosser_id', $location->user_id)->where('crossed_id', $otherLocation->user_id)->first() && Crossing::where('crosser_id', $otherLocation->user_id)->where('crossed_id', $location->user_id)->first()) {
                                $mycrossing = Crossing::where('crosser_id', $location->user_id)->where('crossed_id', $otherLocation->user_id)->first();
                                $yourcrossing = Crossing::where('crosser_id', $otherLocation->user_id)->where('crossed_id', $location->user_id)->first();
                                //only update them when they are true, we don't want too many queries
                                if($mycrossing->meeting && $yourcrossing->meeting) {
                                    $mycrossing->meeting = false;
                                    $mycrossing->save();
                                    $yourcrossing->meeting = false;
                                    $yourcrossing->save();
                                }
                            }
                        }
                    }
                }
            }else{
                if(Crossing::where('crosser_id', $location->user_id)->get()){
                    Crossing::where('crosser_id', $location->user_id)->update(['meeting' => 0]);
                }
                if(Crossing::where('crossed_id', $location->user_id)->get()){
                    Crossing::where('crossed_id', $location->user_id)->update(['meeting' => 0]);
                }
            }

        }
    }
}
