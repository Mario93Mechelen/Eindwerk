<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function photos()
    {
        return $this->morphMany('App\Photo','photoable');
    }
}
