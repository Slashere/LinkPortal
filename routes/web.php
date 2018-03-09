<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'MainController@index')->middleware('checkstatus')->name('main');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('auth');

//Route::get('protected', ['middleware' => ['auth', 'admin'], function() {
//    return "this page requires that you be logged in and an Admin";
//}]);

Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');

Route::get('/mylinks', 'LinkController@index')
    ->name('list_links')
    ->middleware('auth');

Route::get('/show/{link}', 'LinkController@show')
    ->name('show_link');

Route::get('/create', 'LinkController@create')
    ->name('create_link')
    ->middleware('can:create-link');

Route::post('/create', 'LinkController@store')
    ->name('store_link')
    ->middleware('can:create-link');

Route::get('/edit/{link}', 'LinkController@edit')
    ->name('edit_link')
    ->middleware('can:update-link,link');

Route::post('/edit/{link}', 'LinkController@update')
    ->name('update_link')
    ->middleware('can:update-link,link');

Route::delete('/delete/{link}', 'LinkController@destroy')
    ->name('delete_link')
    ->middleware('can:delete-link,link');

Route::get('/user/{id}', 'UserController@show')
    ->name('show_user');

Route::get('/user/edit/{user}', 'UserController@edit')
    ->name('edit_user')
    ->middleware('can:update-user,user');

Route::post('/user/edit/{user}', 'UserController@update')
    ->name('update_user')
    ->middleware('can:update-user,user');