<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    //

    public function conversation()
    {
        return $this->belongsTo('App\Conversation');
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
