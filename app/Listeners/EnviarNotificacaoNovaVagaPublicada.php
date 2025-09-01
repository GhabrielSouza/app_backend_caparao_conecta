<?php

namespace App\Listeners;

use App\Events\NovaVagaPublicada;
use App\Models\Pessoa;
use App\Models\PessoasFisica;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notificacao;
class EnviarNotificacaoNovaVagaPublicada
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
    public function handle(NovaVagaPublicada $event): void
    {
        $vaga = $event->vaga;

        $candidatosDaArea = PessoasFisica::where('area_id', $vaga->area_id)->get();

        foreach ($candidatosDaArea as $candidato) {
            $notificacao = new Notificacao();
            $notificacao->tipo = 'nova_vaga';
            $notificacao->titulo = 'Nova Vaga Publicada';
            $notificacao->dados = [
                'vaga_id' => $vaga->id,
                'vaga_titulo' => $vaga->titulo,
            ];
            $notificacao->id_pessoas_destinatario = $candidato->id_pessoas;
            $notificacao->data_leitura = null;
            $notificacao->save();
        }
    }
}
