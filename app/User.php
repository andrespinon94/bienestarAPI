<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name','password','email'];


    public function userExists($email)
    {
        $users = self::where('email',$email)->get();
        
        foreach ($users as $key => $value) {
            if($value->email == $email){
                return true;
            }
        }
        return false;
    }

    public function create($request){

        $user = new User;

        $user->name = $request->name;      
        $user->email = $request->email;
        $user->password = encrypt($request->password);
        $user->save();
    }

}
