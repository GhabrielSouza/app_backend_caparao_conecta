<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Paises_Cidades extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("pais")->insert([

            'nome_pais' => 'Brasil' 

        ]);

        DB::table("cidades")->insert([

            'nome_cidade' => 'Alegre' ,
            'id_pais' => 1

        ]);

        DB::table("cidades")->insert([

            'nome_cidade' => 'JM' ,
            'id_pais' => 1

        ]);

        DB::table("cidades")->insert([

            'nome_cidade' => 'SP' ,
            'id_pais' => 1

        ]);
    }
}
