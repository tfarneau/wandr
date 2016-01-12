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

Route::get('/', 'PageController@home');

Route::controllers([
    'account' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('me/dashboard', ['middleware' => 'auth', 'uses' => 'UserController@dashboard']);

// Route::get('me/service/{id}/populate', ['middleware' => 'auth', 'uses' => 'AccountController@populate']);
Route::get('me/service/{id}/test', ['middleware' => 'auth', 'uses' => 'ServiceController@test']);
Route::get('me/service/{id}/delete', ['middleware' => 'auth', 'uses' => 'ServiceController@delete']);
Route::get('me/service/create/{slug}', ['middleware' => 'auth', 'uses' => 'ServiceController@create']);
Route::post('me/service/add/{slug}', ['middleware' => 'auth', 'uses' => 'ServiceController@add']);
Route::get('me/service/add/{slug}', ['middleware' => 'auth', 'uses' => 'ServiceController@add']);

Route::get('me/generators', ['middleware' => 'auth', 'uses' => 'GeneratorController@index']);
Route::get('me/generator/create', ['middleware' => 'auth', 'uses' => 'GeneratorController@create']);
Route::get('me/generator/{id}/preview', ['middleware' => 'auth', 'uses' => 'GeneratorController@preview']);
Route::get('me/generator/{id}/edit', ['middleware' => 'auth', 'uses' => 'GeneratorController@edit']);
Route::get('me/generator/{id}/test', ['middleware' => 'auth', 'uses' => 'GeneratorController@test']);

Route::get('me/generator/{id}/activate', ['middleware' => 'auth', 'uses' => 'GeneratorController@activate']);
Route::get('me/generator/{id}/unactivate', ['middleware' => 'auth', 'uses' => 'GeneratorController@unactivate']);

Route::get('me/account', ['middleware' => 'auth', 'uses' => 'UserController@edit']);
Route::post('me/account', ['middleware' => 'auth', 'uses' => 'UserController@save']);

Route::group(['prefix' => 'api'], function()
{
    Route::get('generators/actions/{force}/{action}/{param?}/{param2?}/{param3?}', ['middleware' => 'auth', 'uses' => 'GeneratorController@actions']);
    Route::post('generator/save', ['middleware' => 'auth', 'uses' => 'GeneratorController@save']);

    // Route::get('me', 'UserController@index')->middleware(['jwt.auth']);

    // Route::get('me/activities/{id}', 'ActivityController@show')->middleware(['jwt.auth']);
    // Route::get('me/activities', 'ActivityController@index')->middleware(['jwt.auth']);

    // Route::get('me/generators/{id}', 'GeneratorController@show')->middleware(['jwt.auth']);
    // Route::get('me/generators', 'GeneratorController@index')->middleware(['jwt.auth']);

    // Route::get('me/reports/{id}', 'ReportController@show')->middleware(['jwt.auth']);
    // Route::get('me/reports', 'ReportController@index')->middleware(['jwt.auth']);

    // Route::get('me/services/{slug}/{action}', 'ServiceController@action')->middleware(['jwt.auth']);
    // Route::get('me/services/{slug}', 'ServiceController@show')->middleware(['jwt.auth']);
    // Route::get('me/services', 'ServiceController@index')->middleware(['jwt.auth']);

    // Route::post('register', 'UserController@register');
    // Route::post('login', 'UserController@authenticate');
});

/*Route::group(['prefix' => 'debugger'], function () {
    Route::get('/', 'ApiController@dashboard');
});*/