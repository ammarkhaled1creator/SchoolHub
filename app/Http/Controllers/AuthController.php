<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


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

    public function register(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'unique:users,phone'],
            'role_id' => ['nullable', 'exists:roles,id'],
        ]);

        $defaultRole = Role::firstOrCreate(['name' => 'user']);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'role_id' => $request->role_id ?? $defaultRole->id,
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'access token' => $token,
            'token type' => 'bearer',
        ], 201);
    }

    /**
     * 1 endpoint forgetPassword email (send link) ->send el reset link
     * 2 reset password change ->change Password
     */
    public function forgetPassword(Request $request){
        $request->validate([
            'email'=>['required','email','exists:users,email']
        ]);
        //generate reset link , send via email
        $status=Password::sendResetLink($request->only('email'));
        if($status==Password::RESET_LINK_SENT){
            return response()->json(["message"=>$status]);
        }
        return response()->json(["message"=>$status],422);
    }

    public function resetPassword(Request $request, $token, $email){
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $credentials = [
            'email' => $email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
            'token' => $token,
        ];

        $status = Password::reset(
            $credentials,
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response()->json(["message" => __($status)]);
        }

        return response()->json(["message" => __($status)], 422);
    }
}
