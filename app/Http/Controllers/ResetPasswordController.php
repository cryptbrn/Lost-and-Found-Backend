<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function sendReset(){
        $credentials = request()->validate(['email'=>'required|email']);

        Password::sendResetLink($credentials);
        return response()->json([
            'success' => true,
            'message' => 'Reset password link sent on yout email address'
        ]); 
    }

    public function reset(){
        $credentials = request()->validate([
            'email' => 'required|email',
            'password' => 'required|string|max:25|confirmed',
            'token' => 'required|string'
        ]);

        $email_password_status = Password::reset($credentials, function($user, $password){
            $user->password = bcrypt($password);
            $user->save();
        });

        if($email_password_status== Password::INVALID_TOKEN){
            return response()->json([
                'success'=>false,
                'message'=>'Token Invalid'
            ]);
        }


    }
}
