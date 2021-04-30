<?php

use \App\Http\Middleware\JwtAuthenticate;

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

// Route::namespace('Auth')->group(function (){
//     Route::post('register', 'RegisterController');
//     Route::post('login', 'LoginController');
//     Route::post('logout', 'LogoutController');
//     Route::get('auth','AuthController');

// });



Route::post('register','AuthController@register');
Route::post('login','AuthController@login');
Route::get('auth','AuthController@auth');
Route::post('logout','AuthController@logout');
Route::get('post','PostController@show');
Route::get('post/{id}','PostController@showbyId');

Route::middleware([JwtAuthenticate::class])->group(function(){
    Route::post('post/create-new','PostController@store');
    Route::post('user','UserController@update');
    Route::delete('user','UserController@delete');
    Route::get('user/{id}','UserController@showbyId');
    Route::post('post/{id}', 'PostController@update');
    Route::delete('post/{id}','PostController@destroy');
    Route::post('post-status/{id}', 'PostController@updateStatus');
});


