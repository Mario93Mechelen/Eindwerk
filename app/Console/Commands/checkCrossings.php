<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Crossing;
use App\Location;

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
            $otherLocations = Location::where('user_id', '!=', $location->user_id)->get();
            foreach($otherLocations as $otherLocation) {
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

                if ($kms <= 0.25) {
                    //ladies and gents, we've got a crossing right here
                    if(!Crossing::where('crosser_id', $location->user_id)->where('crossed_id', $otherLocation->user_id)->first() && !Crossing::where('crosser_id', $otherLocation->user_id)->where('crossed_id', $location->user_id)->first()) {
                        $crossing = new Crossing();
                        $crossing->crosser_id = $location->user_id;
                        $crossing->crossed_id = $otherLocation->user_id;
                        $crossing->save();
                    }
                }
            }

        }
    }
}
