<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Staff;
use Exception;



class AuthController extends Controller
{
    public function register(Request $request){
        try{
            $user = User::create([
                'name' => request('name'),
                'username' => request('username'),
                'email' => request('email'),
                'password' => bcrypt(request('password')),
                'telephone' => request('telephone'),
                'role' => request('role'),
                'picture'=> ''
                ]);

            if($request->role=='student'){
                Student::create([
                    'user_id'=> $user->id,
                    'nim'=>request('nim'),
                    'faculty'=>request('faculty'),
                    'department'=>request('department'),
                    'batch'=>request('batch'),
                ]);
            }

            if($request->role=='lecturer'){
                Lecturer::create([
                    'user_id'=> $user->id,
                    'nip'=>request('nip'),
                    'faculty'=>request('faculty'),
                    'department'=>request('department'),
                ]);
            }

            if($request->role=='staff'){
                Staff::create([
                    'user_id'=> $user->id,
                    'nip'=>request('nip'),
                    'unit'=>request('unit'),
                ]);
            }

            return response()->json([
                'success'=>true,
                'message'=>'Registration Success'
            ]);
        }
        catch(Exception $excp){
            return response()->json([
                'success'=>false,
                'message'=>''.$excp
            ]);
        }
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(!$token = auth()->attempt($request->only('email', 'password'))){
            return response()->json([
                'success'=>false,
                'message'=>'Credentials Invalid'
            ]);
        }

        return response()->json(compact('token'));

    }

    public function auth(Request $request){
        if($request->user()==null){
            return response()->json([
                'success'=>false,
                'message'=>'Token Invalid',
            ]);
        }
        else{
            $success = true;
            $user = $request->user();
            if($user->role=='student'){
                $user->student=$request->user()->student;
            }
            elseif ($user->role=='lecturer'){
                $user->lecturer=$request->user()->lecturer;
            }
            elseif ($user->role=='staff'){
                $user->staff=$request->user()->staff;
            }
            return response()->json([
                'success'=>true,
                'user'=>$user,
                
            ]);
        }

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
