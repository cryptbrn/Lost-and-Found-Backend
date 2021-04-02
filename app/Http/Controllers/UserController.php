<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Staff;
use Exception;


class UserController extends Controller
{
    public function update(Request $request){
        try{
            $request->id = (int)$request->id;
            $user = User::find($request->id);
            
            $user->name = $request->name;
            $user->username = $request->username;
            $user->telephone = $request->telephone;
    
            if($request->hasFile('picture')){
                $file = $request->file('picture');
                $extenstion = $request->picture->extension();
                $picture_name = $user->id.time().'.'.$extenstion;
                $file->move('storage/user_picture',$picture_name);
                $user->picture = $picture_name;
            }else{
                $user->picture ='';
            }
    
            if($user->role=='student'){
                $student = Student::find($request->id);
                $student->nim = $request->student['nim'];
                $student->faculty = $request->student['faculty'];
                $student->department = $request->student['department'];
                $student->batch = $request->student['batch'];
                $student->update();
            }
            else if($user->role=='lecturer'){
                $lecturer = Lecturer::find($request->id);
                $lecturer->nip = $request->lecturer['nip'];
                $lecturer->faculty = $request->lecturer['faculty'];
                $lecturer->department = $request->lecturer['department']; 
                $lecturer->update();           
            }
            else if($user->role=='staff'){
                $staff = Staff::find($request->id);
                $staff->nip = $request->staff['nip'];
                $staff->unit = $request->staff['unit'];  
                $staff->update();                     
            }
    
            $user->update();
    
    
            return response()->json([
                'success' => true,
                'message' => 'Update Success'
            ]);   
        }
        catch(Exception $excp){
            return response()->json([
                'success'=>false,
                'message'=>''.$excp
            ]);
        }
    }


    public function delete(Request $request){
        try{
            $user = User::find($request->id);
            if($user->role=='student'){
                $student = Student::find($request->id);
                $student->delete();
            }
            else if($user->role=='lecturer'){
                $lecturer = Lecturer::find($request->id);
                $lecturer->delete();
            }
            else if($user->role=='Staff'){
                $staff = Staff::find($request->id);
                $staff->delete();
            }
            $user->delete();
            auth()->logout();

            return response()->json([
                'success' => true,
                'message' => 'user deleted'
            ]);
        }
        catch(Exception $excp){
            return response()->json([
                'success'=>false,
                'message'=>''.$excp
            ]);
        }

    }

    public function showbyId($id){
        if(User::where('role', '=', 'staff')->find($id)!=null){
            $user = User::with('staff')->find($id);
        }
        else if(User::where('role', '=', 'student')->find($id)!=null){
            $user = User::with('student')->find($id);
        }
        else if(User::where('role', '=', 'lecturer')->find($id)!=null){
            $user = User::with('lecturer')->find($id);
        }
        else {
            $user=null;
        }


        if($user!=null){
            return response()->json([
                'success' => true,
                'user' => $user,
            ]);
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }
    }
}
