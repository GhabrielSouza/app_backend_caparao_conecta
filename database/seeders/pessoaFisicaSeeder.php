<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;



class pessoaFisicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pessoasFisicas')->insert([
            'id_pessoas' => 2,
            'cpf' => Str::random(11),
            'data_de_nascimento' => '20030916',
            'sobrenome' => Str::random(10),
            'cad_unico' => Str::random(9),
            'genero' => Str::random(1),
        ]);
    }
}
