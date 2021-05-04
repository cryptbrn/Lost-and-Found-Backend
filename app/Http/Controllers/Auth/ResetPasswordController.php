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
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|string|max:25|confirmed',
            'token' => 'required|string'
        ]);
        $credentials = request()->all();
            $email_password_status = Password::reset($credentials, function($user, $password){
                $user->password = bcrypt($password);
                $user->save();
            });
    
            if($email_password_status== Password::INVALID_TOKEN){
                return redirect()->to('/password-error');
            }
            return redirect()->to('/password-changed');
    }
}
