<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class AuthController extends Controller
{
    public function register(Request $request){
        User::create([
            'name' => request('name'),
            'username' => request('username'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'telephone' => request('telephone'),
            'role' => request('role'),
            'faculty' => request('faculty'),
            'department' => request('department'),
            'batch' => request('batch'),
        ]);


        return response('Registration Success');
        
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(!$token = auth()->attempt($request->only('email', 'password'))){
            return response(null, 401);
        }

        return response()->json(compact('token'));

    }

    public function auth(Request $request){
        if($request->user()==null){
            $success = false;
        }
        else{
            $success = true;
        }
        return response()->json([
            'success'=>$success,
            'user'=>$request->user()
            
        ]);

    }

    public function logout(Request $request){
        if($request->user()==null){
            $success = false;
            $message = "Logout Failed";
        }
        else{
            auth()->logout();
            $success = true;
            $message = 'Logout Success';
        }
        return response()->json([
            'success'=>$success,
            'message'=>$message,
            
        ]);

    }

    
}
