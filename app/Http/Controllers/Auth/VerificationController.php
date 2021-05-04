<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class VerificationController extends Controller
{
    public function verify($id, Request $request){
        if(!$request->hasValidSignature()){
            return redirect()->to('/email-error');
        }

        $user = User::findOrFail($id);
        if(!$user->hasVerifiedEmail()){
            $user->markEmailAsVerified();
        }

        return redirect()->to('/email-verified');
    }


    public function resend(){
        if(auth()->user()->hasVerifiedEmail()){
            return response()->json([
                'success'=>false,
                'message'=> 'User telah verifikasi'
            ]);
        }

        auth()->user()->sendEmailVerificationNotification();
        return $this->respondWithMessage("New verification link has been sent to your email");
    }
}
