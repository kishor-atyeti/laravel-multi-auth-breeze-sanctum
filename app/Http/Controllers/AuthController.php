<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken($user->name)->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'status' => 201,
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function login(Request $request) {

        $request->validate([
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => 401
            ], 401);
        }

        $token = $user->createToken($user->name)->plainTextToken;
        return response()->json([
            'message' => 'User logged in successfully',
            'status' => 200,
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request) {

        $request->user()->currentAccessToken()->delete();
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'User logged out successfully',
            'status' => 200
        ]);
    }
}
