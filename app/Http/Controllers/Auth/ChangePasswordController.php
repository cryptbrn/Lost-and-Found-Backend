<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Hash;

class ChangePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $currentPassword = auth()->user()->password;
        $oldPassword = request("old_password");
        if(Hash::check($oldPassword, $currentPassword)){
            try{
                auth()->user()->update([
                    'password' => bcrypt(request('password'))
                ]);
                return response()->json([
                    'success'=>true,
                    'message'=>"Password changed succesfully",
                ]);
                
            }
            catch(Exception $excp){
                return response()->json([
                    'success'=>false,
                    'message'=>''.$excp
                ]);
            }
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"The old password you have entered is incorrect"
            ]);
        }
    }
}
