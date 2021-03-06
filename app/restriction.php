<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class restriction extends Model
{
    protected $table = 'restrictions';
    protected $fillable = ['max_time','start_hour_restriction','finish_hour_restriction','user_id','application_id'];


    public function new_Restriction($request,$user_id,$application_id)
    {
        $restriction = new restriction;
        $restriction->max_time = $request->max_time;
        $restriction->start_hour_restriction = $request->start_hour_restriction;
        $restriction->finish_hour_restriction = $request->finish_hour_restriction;
        $restriction->user_id = $user_id;
        $restriction->application_id = $application_id;
        $restriction->save();
    }


}
