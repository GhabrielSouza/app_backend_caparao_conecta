<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacaoController extends Controller
{
    public function index(Request $request)
    {
        $notificacoes = $request->user()->pessoa->notificacoes()->orderBy('created_at')->get();
        return response()->json($notificacoes);
    }

    public function marcarTodasComoLidas(Request $request)
    {
        $request->user()->pessoa->notificacoes()->update(['data_leitura' => now()]);
        return response()->json(['message' => 'Todas as notificações marcadas como lidas.']);
    }
}
