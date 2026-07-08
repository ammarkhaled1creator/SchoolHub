<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
 
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'unique:users,phone'],
        ]);
 
        $user->fill($validated);
        $user->save();
 
        return response()->json([
            'message' => 'Profile updated successfully.',
            'data' => $user
        ]);
    }
 
    public function changePassword(Request $request)
    {
        $user = auth('api')->user();
 
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
            'new_password_confirmation' => ['required', 'string'],
        ]);
 
        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json(['message' => 'Current password is incorrect.'], 422);
        }
 
        $user->password = $validated['new_password'];
        $user->save();
 
        return response()->json(['message' => 'Password changed successfully.']);
    }

    public function getallusers()
    {
        //default number for the page is one, but if user enters any number it will be accepted
        $page=request('page',1);
        $allusers=Cache::remember("AllUsers_page",3600,function(){
            return User::Paginate(10);
    });
        return response()->json([
            'message'=>'All users',
            'data'=>$allusers
        ],200);
    }

    
}
