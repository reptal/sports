<?php

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
Route::group(['namespace' => 'api\v1'], function () {

    //login user and get token
    Route::post('auth/login', 'AuthController@login');

    //auth users
    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('dashboard', 'DashboardController@index');
        //players of team
        Route::get('teams/{team}/players', 'TeamController@getPlayers');
        //teams
        Route::resource('teams', 'TeamController');
        //players
        Route::resource('players', 'PlayerController');
    });
});
