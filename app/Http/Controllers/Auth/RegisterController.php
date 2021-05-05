<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Staff;
use Exception;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['string', 'required', 'unique:users,username'],
            'telephone' => ['string', 'required', 'unique:users,telephone'],
            'email' => ['string', 'required', 'unique:users,email'],
        ]);
        if($validator -> fails()){
            return response()->json([
                'success'=>false,
                'message'=> $validator->messages()->first()
            ]);
        }
        else{
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
                
                $user->sendEmailVerificationNotification();
    
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
    }
}
