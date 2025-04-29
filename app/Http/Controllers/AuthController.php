<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        $attempt = auth()->attempt(['email' => $email, 'password' => $password]);

        if (!$attempt) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = auth()->user();
        $token = $user->createToken($user->email, ['*'], now()->addHour())->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->delete();
        return response()->json(['message' => 'Logout successful'], 200);
    }
}
