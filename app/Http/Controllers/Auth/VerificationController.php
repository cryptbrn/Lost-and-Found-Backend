<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class VerificationController extends Controller
{
    public function verify($id, Request $request){
        if(!$request->hasValidSignature()){
            return response()->json([
                'success'=>false,
                'message'=> 'Error'
            ]);
        }

        $user = User::findOrFail($id);
        if(!$user->hasVerifiedEmail()){
            $user->markEmailAsVerified();
        }

        return redirect()->to('/');
    }


    public function resend(){
        if(auth()->user()->hasVerifiedEmail()){
            return response()->json([
                'success'=>false,
                'message'=> 'User telah verifikasi'
            ]);
        }

        auth()->user()->sendEmailVerificationNotification();
        return $this->respondWithMessage("Email sudah dikirim");
    }
}
