<?php
//Primeiro
namespace Database\Seeders;
use DB;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class paisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');

        for ($i = 0; $i < 10; $i++){
            DB::table('pais')->insert([
                'nome_pais' => $faker->country(),
            ]);
        }
    }
}
