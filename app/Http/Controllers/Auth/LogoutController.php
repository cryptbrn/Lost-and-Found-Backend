<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
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
