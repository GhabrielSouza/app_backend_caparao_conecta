<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDeCursos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("tipo_de_cursos")->insert([

            'id_tipo_de_cursos' => 1,
            'nome' => 'PRESENCIAL'

        ]);

        DB::table("tipo_de_cursos")->insert([

            'id_tipo_de_cursos' => 2,
            'nome' => 'ONLINE'

        ]);

        DB::table("tipo_de_cursos")->insert([

            'id_tipo_de_cursos' => 3,
            'nome' => 'HÍBRIDO'

        ]);
    }
}
