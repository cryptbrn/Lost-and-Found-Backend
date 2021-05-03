<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
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
}
