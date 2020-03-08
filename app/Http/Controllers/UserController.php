<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Helpers\Token;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        
        if (!$user->userExists($request->email)) 
        {
            $user->create($request);

            return $this->login($request);



        }return response()->json(["Error" => "No se pueden crear usuarios con el mismo email o con el email vacío"], 400);

    }

    public function login(Request $request)
    {
        $data_token = ['email'=>$request->email];
        
        $user = User::where($data_token)->first();
       
        if ($user!=null) 
        {
            if ($request->password == decrypt($user->password)) 
            {
                $token = new Token($data_token);
                $tokenEncoded = $token->encode();
                return response()->json(["token" => $tokenEncoded], 201);
            }
        }
        return response()->json(["Error" => "No se ha encontrado"], 401);
    }

    public function recoverPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (isset($user)) {
            $newPassword = self::randomPassword();
            self::sendEmail($user->email, $newPassword);
            
            $user->password = encrypt($newPassword);
            $user->update();
            
            return response()->json(["Success" => "Se ha restablecido su contraseña, revise su correo electronico."]);
        } else {
            return response()->json(["Error" => "El email no existe"]);
        }
    }

    public function sendEmail($email, $newPassword)
    {
        $para      = $email;
        $titulo    = 'Recuperar contraseña de ifoodie';
        $mensaje   = 'Se ha establecido "'.$newPassword.'" como su nueva contraseña.';
        mail($para, $titulo, $mensaje);
    }
    
    public function randomPassword()
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        $email = $request->data_token->email;
        $user = User::where('email',$email)->first();
        if(isset($user)){
            $user->password = decrypt($user->password);
            return response()->json(["Success" => $user]);
        }else{
            return response()->json(["Error" => "El usuario no existe"]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = user::where('email',$request->data_token->email)->first();
        if (isset($user)) {
            
            $user->name = $request->name;
            $user->password = encrypt($request->password);
            $user->update();
        
            return response()->json(["Success" => "Se ha modificado el usuario."]);
        }else{
            return response()->json(["Error" => "El usuario no existe"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
