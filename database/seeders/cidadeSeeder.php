<?php
//Segundo
namespace Database\Seeders;
use DB;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class cidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');
       for($i = 1; $i != 10; $i++){
            DB::table('cidades')->insert([
           'nome_cidade' =>$faker->city(),
            'id_pais' =>$i,
        ]);
       } 
    }
}
