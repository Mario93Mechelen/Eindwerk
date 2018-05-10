<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'token',
        'gender',
        'birthday'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function myCrossings()
    {
        return $this->belongsToMany('App\User','crossings','crosser_id','crossed_id');
    }

    public function myLocation()
    {
        return $this->hasOne('App\Location', 'user_id','id');
    }

    public function conversation()
    {
        return $this->belongsToMany('App\Conversation');
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }
}
