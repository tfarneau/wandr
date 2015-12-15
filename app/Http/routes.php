<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => 'api'], function()
{
    Route::get('me', 'UserController@index')->middleware(['jwt.auth']);
    Route::get('checkpoints', 'CheckpointsController@index')->middleware(['jwt.auth']);
    Route::get('calculate', 'ItinerariesController@calculate');
    Route::post('register', 'UserController@register');
    Route::post('login', 'UserController@authenticate');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'ApiController@dashboard');
});