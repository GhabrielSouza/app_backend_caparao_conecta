<?php

namespace App\Listeners;

use App\Events\PerfilVisualizadoPorEmpresa;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


use App\Models\Notificacao;

class NotificarCandidatoSobreVisualizacao
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
    public function handle(PerfilVisualizadoPorEmpresa $event): void
    {
        Notificacao::create([
            'tipo' => 'perfil_visualizado',
            'titulo' => 'Seu perfil foi visualizado!',
            'id_pessoas_destinatario' => $event->perfilVisualizado->id_pessoas,
            'dados' => [
                'nome_empresa' => $event->empresaVisualizadora->pessoa->nome,
            ]
        ]);
    }
}
