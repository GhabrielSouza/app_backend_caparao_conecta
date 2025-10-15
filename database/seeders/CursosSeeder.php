<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CursosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cursos')->insert([
            [
                'curso' => 'Técnico em Informática para Internet',
                'cargo_horaria' => '1200h',
                'id_tipo_de_cursos' => 1, // Assumindo que 1 = Técnico
                'id_instituicoes' => 1, // Assumindo que 1 = IFES
            ],
            [
                'curso' => 'Boas Práticas em Atendimento ao Cliente',
                'cargo_horaria' => '40h',
                'id_tipo_de_cursos' => 2, // Assumindo que 2 = Profissionalizante
                'id_instituicoes' => 4, // Assumindo que 4 = SENAC
            ],
            [
                'curso' => 'Segurança no Trabalho para Construção Civil',
                'cargo_horaria' => '60h',
                'id_tipo_de_cursos' => 2,
                'id_instituicoes' => 3, // Assumindo que 3 = SENAI
            ],
            [
                'curso' => 'Bacharelado em Sistemas de Informação',
                'cargo_horaria' => '3200h',
                'id_tipo_de_cursos' => 3, // Assumindo que 3 = Superior
                'id_instituicoes' => 2, // Assumindo que 2 = UFES
            ],
        ]);
    }
}
