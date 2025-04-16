<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoUsuarios extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("tipo_usuarios")->insert([

            'id_tipo_usuarios' => 1,
            'nome' => 'ADMIN'

        ]);

        DB::table("tipo_usuarios")->insert([

            'id_tipo_usuarios' => 2,
            'nome' => 'CANDIDATO'

        ]);

        DB::table("tipo_usuarios")->insert([

            'id_tipo_usuarios' => 3,
            'nome' => 'EMPRESA'

        ]);
    }
}
