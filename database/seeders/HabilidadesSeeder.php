<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HabilidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('habilidades')->insert([
            // Soft Skills
            ['nome' => 'Comunicação Eficaz', 'status' => 'Ativo'],
            ['nome' => 'Trabalho em Equipa', 'status' => 'Ativo'],
            ['nome' => 'Resolução de Problemas', 'status' => 'Ativo'],
            ['nome' => 'Liderança', 'status' => 'Ativo'],
            ['nome' => 'Adaptabilidade', 'status' => 'Ativo'],
            ['nome' => 'Pensamento Crítico', 'status' => 'Ativo'],
            ['nome' => 'Criatividade', 'status' => 'Ativo'],
            ['nome' => 'Gestão de Tempo', 'status' => 'Ativo'],

            // Hard Skills (Exemplos de TI)
            ['nome' => 'Laravel', 'status' => 'Ativo'],
            ['nome' => 'Angular', 'status' => 'Ativo'],
            ['nome' => 'PHP', 'status' => 'Ativo'],
            ['nome' => 'JavaScript', 'status' => 'Ativo'],
            ['nome' => 'MySQL', 'status' => 'Ativo'],
            ['nome' => 'Docker', 'status' => 'Ativo'],
            ['nome' => 'Git', 'status' => 'Ativo'],
        ]);
    }
}
