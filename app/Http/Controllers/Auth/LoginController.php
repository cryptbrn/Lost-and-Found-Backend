<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $email = request('email');
        $username = request('username');
        $password = request('password');
        if($username==""){
            if(!$token = auth()->attempt($request->only('email', 'password'))){
                return response()->json([
                    'success'=>false,
                    'message'=>'Credentials Invalid'
                ]);
            }
            $user = auth()->user();
            if(!$user->hasVerifiedEmail()){
                return response()->json([
                    'success'=>false,
                    'message'=>'You need to validate your email address first, we have sent you verification link, please check your email'
                ]);
            }
            if($user->is_deactivated){
                return response()->json([
                    'success'=>false,
                    'message'=>'Your account has been deactivated, please contact admin'
                ]);
            }

    
            return response()->json([
                'success'=>true,
                'token'=>$token
            ]);
        }
        else{
            if(!$token = auth()->attempt($request->only('username', 'password'))){
                return response()->json([
                    'success'=>false,
                    'message'=>'Credentials Invalid'
                ]);
            }


            $user = auth()->user();
            if(!$user->hasVerifiedEmail()){
                return response()->json([
                    'success'=>false,
                    'message'=>'You need to validate your email address first, we have sent you verification link, please check your email'
                ]);
            }

            if($user->is_deactivated){
                return response()->json([
                    'success'=>false,
                    'message'=>'Your account has been deactivated, please contact admin'
                ]);
            }

    
            return response()->json([
                'success'=>true,
                'token'=>$token
            ]);
        }
    }
}
