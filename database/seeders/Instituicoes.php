<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Instituicoes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("instituicoes")->insert([
            [
                'nome' => 'Instituto Federal do Espírito Santo (IFES)',
                'id_cidades' => 1, // Adapte o ID da cidade conforme necessário
            ],
            [
                'nome' => 'Universidade Federal do Espírito Santo (UFES)',
                'id_cidades' => 1, // Adapte o ID da cidade conforme necessário
            ],
            [
                'nome' => 'SENAI',
                'id_cidades' => 1, // Adapte o ID da cidade conforme necessário
            ],
            [
                'nome' => 'SENAC',
                'id_cidades' => 1, // Adapte o ID da cidade conforme necessário
            ],
        ]);
    }
}
