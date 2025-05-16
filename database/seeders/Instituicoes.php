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

            'nome' => 'Instituto Federal do Rio Grande do Sul',
            'id_cidades' => 1,

        ]);
    }
}
