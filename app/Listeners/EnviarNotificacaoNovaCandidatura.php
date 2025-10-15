<?php

namespace App\Listeners;

use App\Events\NovaCandidatura;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notificacao;

class EnviarNotificacaoNovaCandidatura
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NovaCandidatura $event): void
    {
        $vaga = $event->vaga;
        $candidato = $event->candidato;

        $empresa = $vaga->empresa;

        if ($empresa && $empresa->pessoa) {
            $notificacao = new Notificacao();
            $notificacao->tipo = 'nova_candidatura';
            $notificacao->titulo = 'Nova Candidatura Recebida';
            $notificacao->dados = [
                'id_vagas' => $vaga->id_vagas,
                'titulo_vaga' => $vaga->titulo_vaga,
                'candidato_id' => $candidato->id_pessoas,
                'candidato_nome' => $candidato->pessoa->nome . ' ' . $candidato->sobrenome,
            ];
            $notificacao->id_pessoas_destinatario = $empresa->pessoa->id_pessoas;
            $notificacao->data_leitura = null;
            $notificacao->save();
        }
    }
}
