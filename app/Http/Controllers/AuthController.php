<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Inicia uma sessão segura para o usuário.
            $request->session()->regenerate();

            // Retorna os dados do usuário, sem nenhum token.
            return response()->json(Auth::user());
        }

        return response()->json([
            'message' => 'As credenciais fornecidas estão incorretas.'
        ], 401);
    }

    public function logout(Request $request)
    {
        // Faz o logout da sessão web.
        Auth::guard('web')->logout();

        // Invalida a sessão e regenera o token CSRF.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }
}
