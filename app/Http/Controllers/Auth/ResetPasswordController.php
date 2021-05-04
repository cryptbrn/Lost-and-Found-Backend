<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class ResetPasswordController extends Controller
{
    public function sendReset(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>'required|email'
        ]);
        if($validator -> fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->messages()->first()
            ]); 
        }
        else{
            $credentials = request()->all();
            Password::sendResetLink($credentials);
            return response()->json([
                'success' => true,
                'message' => 'Reset password link has been sent to your your email address'
            ]);
        }
    }

    public function reset(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|max:25|confirmed',
            'token' => 'required|string'
        ]);
        if($validator -> fails()){
            return redirect()->back()->withErrors($validator->errors()->all());
        }
        else {
            $credentials = request()->all();
            $email_password_status = Password::reset($credentials, function($user, $password){
                $user->password = bcrypt($password);
                $user->save();
                return redirect()->to('/password-changed');
            });
    
            if($email_password_status== Password::INVALID_TOKEN){
                return redirect()->to('/password-error');
            }
        }


        


    }
}
