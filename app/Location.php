<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'longitude',
        'latitude',
        'city',
        'user_id',

    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
