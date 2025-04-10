<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class pessoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pessoas')->insert([
            'nome' => Str::random(10),
            'telefone' => Str::random(9),
            'sobre' => Str::random(40),
            'imagem' => Str::random(10),
        ]);
    }
}
