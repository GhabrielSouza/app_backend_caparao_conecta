<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AreaAtuacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            ['nome_area' => 'Tecnologia da Informação (TI)'],
            ['nome_area' => 'Saúde e Medicina'],
            ['nome_area' => 'Engenharia Civil'],
            ['nome_area' => 'Engenharia de Software'],
            ['nome_area' => 'Marketing e Vendas'],
            ['nome_area' => 'Recursos Humanos (RH)'],
            ['nome_area' => 'Finanças e Contabilidade'],
            ['nome_area' => 'Design Gráfico e UX/UI'],
            ['nome_area' => 'Educação'],
            ['nome_area' => 'Direito e Advocacia'],
            ['nome_area' => 'Administração e Gestão'],
            ['nome_area' => 'Logística e Transporte'],
            ['nome_area' => 'Agricultura e Agronegócio'],
            ['nome_area' => 'Turismo e Hotelaria'],
            ['nome_area' => 'Comunicação e Jornalismo'],
        ];

        DB::table('areas_atuacao')->insert($areas);
    }
}
