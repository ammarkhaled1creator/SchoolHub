<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

public function getAllUsers(Request $request)
{
    $page = $request->input('page', 1);

    $allUsers = Cache::remember(
        "all_users_page_{$page}",
        now()->addHour(),
        function () {
            return User::paginate(10);
        }
    );

    return response()->json([
        'message' => 'All users retrieved successfully.',
        'data' => $allUsers,
    ], 200);
}
  
    public function destroy(string $id){
        $user=User::findOrFail($id);
        $user->delete();
        Cache::forget("AllUsers_page");
        return response()->json([
            'message'=>'user deleted successfully.'
        ],200);
    }
    public function show(string $id)
   {
    $user = User::findOrFail($id);

    return response()->json([
        'message' => 'User retrieved successfully.',
        'data' => $user,
    ], 200);
   }



    
}
