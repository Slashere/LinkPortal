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


Route::get('/user/{user}', 'API\UserController@show')
    ->name('api_show_user');

Route::post('/user', 'API\UserController@store')
    ->name('api_store_user');

Route::get('/show/{link}', 'API\LinkController@show')
    ->name('api_show_link');

Route::middleware('auth:api')->group(function () {

    Route::put('/user/{user}', 'API\UserController@update')
        ->name('api_update_user')
        ->middleware('can:update-user,user');


    Route::delete('/user/{user}', 'API\UserController@destroy')
        ->name('api_delete_user')
        ->middleware('can:delete-user,user');

});
