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
    Route::get('me/requests', 'UserController@requests')->middleware(['jwt.auth']);

    Route::get('me/itineraries', 'ItinerariesController@index')->middleware(['jwt.auth']);
    Route::get('me/itineraries/favorites', 'ItinerariesController@favorites')->middleware(['jwt.auth']);
    Route::post('me/itineraries/{id}/favorite', 'ItinerariesController@favorite')->middleware(['jwt.auth']);
    Route::post('me/itineraries/{id}/unfavorite', 'ItinerariesController@unfavorite')->middleware(['jwt.auth']);
    Route::get('me/itineraries/{id}', 'ItinerariesController@index')->middleware(['jwt.auth']);
   
    Route::get('checkpoints', 'CheckpointsController@index')->middleware(['jwt.auth']);
    Route::get('calculate', 'ItinerariesController@calculate')->middleware(['jwt.auth']);
    Route::post('register', 'UserController@register');
    Route::post('login', 'UserController@authenticate');
});

Route::group(['prefix' => 'debugger'], function () {
    Route::get('/', 'ApiController@dashboard');
    Route::get('/simulator', 'ApiController@simulator');
});