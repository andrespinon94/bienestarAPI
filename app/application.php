<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class application extends Model
{
    protected $table = 'applications';
    protected $fillable = ['name','icon'];


    public function new_application($request)
    {
        $application = new application;
        $application->name = $request->name;
        $application->icon = $request->icon;
        $application->save();
    }
    
    Public function applicationExists($name){
        $applications = self::where('name',$name)->get();
        
        foreach ($applications as $key => $value) {
            if($value->name == $name){
                return true;
            }
        }
        return false;
    }
    Public function get_applications(){
        $applications = self::all();
        return $applications;
    }


}
