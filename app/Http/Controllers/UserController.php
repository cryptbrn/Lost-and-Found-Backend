<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function update(Request $request){
        $user = User::where('id', $request->id)->update(request()->all());
        return response()->json([
            'success' => true,
            'message' => 'user updated'
        ]);    
    }


    public function delete(Request $request){
        $user = User::find($request->id);
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'user deleted'
        ]);
    }
}
