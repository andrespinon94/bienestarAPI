<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class usage extends Model
{
    protected $table = 'usage';
    protected $fillable = ['day','useTime','location','user_id','application_id'];


    public function register($day,$useTime,$location,$user_id,$application_id)
    {
        $usage = new usage;
        $usage->day = $day;
        $usage->useTime = $useTime;
        $usage->location = $location;
        $usage->user_id = $user_id;
        $usage->application_id = $application_id;
        $usage->save();
    }
    
}
