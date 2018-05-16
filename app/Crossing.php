<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crossing extends Model
{

    public function crossingLocations()
    {
        return $this->hasMany('App\CrossingLocation','crossing_id', 'id');
    }

}
