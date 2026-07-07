<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
        {
            $credentials = $request->only('email', 'password');
                $token = auth('api')->attempt($credentials);
            if(!$token) {
                return response()->json(['message'=>"Invalid email or password"], 401);
            }
            return response()->json([
                'message'=>"user logged in",
                'token'=>$token
            ]);
        }
    public function me()
        {
            $user=auth('api')->user();
            return response ()->json([
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'role'  => $user->role?->name,
        ], 200);
    }
    public function logout()
        {
            auth('api')->logout();
            return response()->json(['message'=> 'user logged out']);

        }
    public function refresh()
        {
            $token=auth('api')->refresh();
            return response()->json(
                [
                    'token'=>$token
                ]
            );
        }
}
