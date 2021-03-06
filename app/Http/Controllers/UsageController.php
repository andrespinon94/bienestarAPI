<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DateTime;
use App\usage;
use App\application;
use DB;

class UsageController extends Controller
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
        $csv = array_map('str_getcsv' , file('C:\xampp\htdocs\bienestar\app\usage.csv'));

        $csvLength = count($csv);

        $email = $request->data_token->email;
        $user = User::where('email', $email)->first();

        for ($i=1; $i < $csvLength ; $i++) { 

                $openDate = new DateTime ($csv[$i][0]);
                $application = $csv[$i][1];
                $openLocation = $csv[$i][3] . "," . $csv[$i][4];

                $i++;

                $closeDate =  new DateTime ($csv[$i][0]);

                $timeUsed = $closeDate->getTimestamp() - $openDate->getTimestamp();

                $application = application::where('name',$application)->first();

                if (isset($application)) {

                    $newUsage = new usage();
                    $newUsage->register($openDate,$timeUsed,$openLocation,$user->id,$application->id);   
                }               


            }
            return response()->json(["Success" => "Se ha añadido el uso de todas las aplicaciones"]);
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
      
        $usages = usage::where('user_id',$user->id)->get();
        
        
        return response()->json($usages , 200);

    }
    
    public function map(Request $request)
    {
        $email = $request->data_token->email;
        $user = User::where('email',$email)->first();
        $usage = new usage();        
        $usages = $usage->getLocationUsage($user->id);

        return response()->json($usages , 201);
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
        //
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
