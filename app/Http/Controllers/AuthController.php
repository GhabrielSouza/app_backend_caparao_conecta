<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
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

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:usuarios,email']);

        $status = Password::broker()->sendResetLink($request->only('email'));

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'E-mail de recuperação enviado com sucesso!']);
        }

        return response()->json(['message' => 'Não foi possível enviar o e-mail.'], 500);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // O Laravel valida o token, encontra o usuário e atualiza a senha
        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Senha alterada com sucesso!']);
        }

        return response()->json(['message' => 'Token inválido ou expirado.'], 400);
    }
}
