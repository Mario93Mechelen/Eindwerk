<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    //

    public function chats()
    {
        return $this->hasMany('App\Chat');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
