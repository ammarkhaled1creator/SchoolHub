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
    public function login(Request $request){
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

            $credentials = $request->only('email', 'password');
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json([
            'message' => 'Invalid email or password',
            ], 401);
        }

        return response()->json([
        'message' => 'Logged in successfully',
        'token' => $token,
        'token_type' => 'Bearer',
        'expires_in' => JWTAuth::factory()->getTTL() * 60
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
            return response()->json(['message'=> 'Logged out successfully']);

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

        $defaultRole = Role::firstOrCreate(['name' => 'User']);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'role_id' => $request->role_id ?? $defaultRole->id,
        ]);

        $token = JWTAuth::fromUser($user);
        $expiry = JWTAuth::factory()->getTTL() * 60;

        return response()->json([
            'message' => 'User registered successfully.',
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => $expiry
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

        $status = Password::sendResetLink($request->only('email'));
        if ($status == Password::RESET_LINK_SENT) {
            return response()->json(["message" => "Password reset link has been sent to your email."]);
        }

        return response()->json(["message" => __($status)], 422);
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
            return response()->json(["message" => "Password has been reset successfully."]);
        }

        return response()->json(["message" => __($status)], 422);
    }

    
}
