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
Route::post('post/create-new','PostController@store')->middleware('jwt.auth');
Route::get('post','PostController@show');
Route::get('post/{id}','PostController@showbyId');
Route::put('user','UserController@update')->middleware('jwt.auth');
Route::delete('user','UserController@delete')->middleware('jwt.auth');
