<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', 'UserController');

Route::post('login', 'UserController@login');

Route::post('recoverPassword','UserController@recoverPassword');



Route::group(['middleware' => ['auth']], function (){

    Route::apiResource('application','ApplicationController');
    Route::apiResource('usage','UsageController');
    Route::apiResource('restriction','RestrictionController');
    Route::get('showlocations','UsageController@map');
    Route::get('show','UserController@show');
    Route::put('update', 'UserController@update');

});