<?php

use \App\Http\Middleware\JwtAuthenticate;
use Illuminate\Support\Facades\Auth;

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

Route::namespace('Auth')->group(function (){
    Route::post('register', 'RegisterController');
    Route::post('login', 'LoginController');
    Route::post('logout', 'LogoutController');
    Route::get('auth','AuthController');
    Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
    Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
    Route::post('password/email','ResetPasswordController@sendReset');
    Route::post('password/reset','ResetPasswordController@reset');

});

Route::get('post','Post\PostController@show');
Route::get('post/{id}','Post\PostController@showbyId');

Route::middleware([JwtAuthenticate::class])->group(function(){
    Route::post('password/change','Auth\ChangePasswordController');
    Route::post('post/create-new','Post\PostController@store');
    Route::post('user','Account\UserController@update');
    Route::delete('user','Account\UserController@deactivate');
    Route::get('user/{id}','Account\UserController@showbyId');
    Route::post('post/{id}', 'Post\PostController@update');
    Route::delete('post/{id}','Post\PostController@destroy');
    Route::post('post-status/{id}', 'Post\PostController@updateStatus');
});


