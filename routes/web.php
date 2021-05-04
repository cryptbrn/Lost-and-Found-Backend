<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
});

Route::view('reset_password', 'auth.reset_password')->name('password.reset');

Route::get('/email-verified', function () {
    return view('auth.email_verified');
});

Route::get('/password-changed', function () {
    return view('auth.password_changed');
});

Route::get('/email-error', function () {
    return view('auth.email_not_verified');
});

Route::get('/password-error', function () {
    return view('auth.password_error');
});
