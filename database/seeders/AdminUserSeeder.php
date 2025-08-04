<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Pessoa;
use App\Models\Usuario;
use App\Models\TipoUsuario;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {

            $tipoAdmin = TipoUsuario::firstOrCreate(
                ['id_tipo_usuarios' => 1],
                ['nome' => 'ADMIN']
            );


            $adminEmail = 'admin@admin.com';
            $adminPassword = '#Conecta2025';

            $usuarioExistente = Usuario::where('email', $adminEmail)->first();

            if (!$usuarioExistente) {
                $pessoaAdmin = Pessoa::create([
                    'nome' => 'Ghabriel',
                    'telefone' => '00000000000',
                ]);


                Usuario::create([
                    'id_pessoas' => $pessoaAdmin->id_pessoas,
                    'email' => $adminEmail,
                    'password' => Hash::make($adminPassword),
                    'id_tipo_usuarios' => $tipoAdmin->id_tipo_usuarios,
                ]);


                $this->command->info('Usuário administrador padrão criado com sucesso!');
                $this->command->info('Email: ' . $adminEmail);
                $this->command->info('Senha: ' . $adminPassword);
            } else {
                $this->command->warn('O usuário administrador padrão já existe.');
            }
        });
    }
}
