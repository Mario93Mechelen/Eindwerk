<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function photos()
    {
        return $this->morphMany('App\Photo','photoable');
    }

    public function calculateTimeElapsed()
    {
        $chatTime = $this->created_at;
        $now = Carbon::now();
        $diff = $now->diffInMinutes($chatTime);
        $timeText = $diff.'m ago';
        if($diff >= 60){
            $diff = $now->diffInHours($chatTime);
            $timeText = $diff.'h ago';
            if($diff >= 24){
                $diff = $now->diffInDays($chatTime);
                $timeText = $diff.' days ago';
                if($diff >= 7){
                    $diff = $now->diffInWeeks($chatTime);
                    $timeText = $diff.' weeks ago';
                    if($diff >= 4){
                        $timeText = $chatTime->format('d m Y');
                    }
                }
            }
        }
        return $timeText;
    }
}
