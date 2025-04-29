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
            return response()->json(['message' => 'Invalid credentials'
        ], 401);
        }

        $user = auth()->user();
        $token = $user->createToken($user->email, ['*'], now()->addHour())->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        // Revoga o token atual
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(['message' => 'Logout realizado com sucesso'], 200);
    }
}
