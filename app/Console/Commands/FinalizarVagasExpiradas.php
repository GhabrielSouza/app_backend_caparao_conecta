<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vaga; // Importe o seu model Vaga
use Carbon\Carbon;   // Importe a classe Carbon para trabalhar com datas

class FinalizarVagasExpiradas extends Command
{
    /**
     * A assinatura do comando no terminal.
     */
    protected $signature = 'vagas:finalizar-expiradas';

    /**
     * A descrição do comando.
     */
    protected $description = 'Verifica e atualiza o status de vagas com data de fechamento expirada para "FINALIZADO"';

    /**
     * Executa a lógica do comando.
     */
    public function handle()
    {
        $this->info('A verificar vagas expiradas...');

        // 1. Procura por todas as vagas que:
        //    - Têm o status 'EM_ANDAMENTO'.
        //    - A 'data_fechamento' é anterior a hoje.
        $vagasExpiradas = Vaga::where('status', 'EM_ANDAMENTO')
            ->whereDate('data_fechamento', '<', Carbon::today())
            ->get();

        if ($vagasExpiradas->isEmpty()) {
            $this->info('Nenhuma vaga expirada encontrada.');
            return 0; // Termina o comando com sucesso
        }

        // 2. Para cada vaga encontrada, atualiza o status
        foreach ($vagasExpiradas as $vaga) {
            $vaga->status = 'FINALIZADO';
            $vaga->save();
            $this->info("Vaga #{$vaga->id_vagas} ('{$vaga->titulo_vaga}') foi finalizada.");
        }

        $this->info('Processo concluído. ' . $vagasExpiradas->count() . ' vaga(s) foram atualizadas.');
        return 0;
    }
}
