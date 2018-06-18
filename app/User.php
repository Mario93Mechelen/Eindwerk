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
        'birthday',
        'school_id',

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
        return $this->belongsToMany('App\Conversation');//->select('conversations.*')->join('chats','conversations.id','=','chats.conversation_id')->groupBy('chats.conversation_id')->orderBy('chats.created_at');
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function friendRequestIsSent($myId,$userId)
    {
        return Friend::where('friend_sender',$myId)->where('friend_receiver',$userId)->where('request_type','pending')->first();
    }

    public function friendRequestIsAccepted($myId, $userId)
    {
        return Friend::where('friend_sender',$myId)->where('friend_receiver',$userId)->where('request_type','friends')->first();
    }

    public function friends()
    {
        return $this->belongsToMany('App\User','friends','friend_sender','friend_receiver');
    }

    public function crossingLocationsPerUser($myId)
    {
        return Crossing::where('crosser_id',$myId)->where('crossed_id',$this->id)->first()->crossingLocations;
    }

    public function setting()
    {
        return $this->hasOne('App\Setting');
    }

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function blocked()
    {
        return $this->belongsToMany('App\User','blocked_users','block_sender','block_receiver');
    }

    public function blockedBy($myId)
    {
        if(BlockedUser::where('block_receiver',$myId)->where('block_sender',$this->id)->first()){
            return true;
        }else{
            return false;
        }
    }

    public function school()
    {
        return $this->belongsTo('App\School');
    }

    public function isBlocked($myId)
    {
        if(BlockedUser::where('block_sender',$myId)->where('block_receiver',$this->id)->first()){
            return true;
        }else{
            return false;
        }
    }

    public function interests()
    {
        return $this->belongsToMany('App\Interest','interest_user');
    }
}
