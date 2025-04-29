<?php

use App\Http\Controllers\Formacao_AcademicaController;

use App\Http\Controllers\ExperienciaController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\EnderecoController;

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\PessoasFisicaController;
use App\Http\Controllers\CandidatoController;

use App\Http\Controllers\VagaController;
use App\Http\Controllers\HabilidadeController;

use App\Models\Endereco;
use App\Models\Habilidade;
use App\Models\PessoasFisica;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return response()->json(
        [
            'status' => 'ok',
            'message' => 'API is runing'
        ],
        200
    );
});


//Rotas de formacoes academicas
Route::get('/formacoes_academicas', [Formacao_AcademicaController::class,'all']);
Route ::get('/formacoes_academicas/{id_experiencia}', [Formacao_AcademicaController::class, 'show']);
Route ::post('/formacoes_academicas', [Formacao_AcademicaController::class, 'store']);
Route::put('/formacoes_academicas/{id_experiencia}', [Formacao_AcademicaController::class,'update']);
Route::delete('/formacoes_academicas/{id_experiencias}', [Formacao_AcademicaController::class,'destroy']);

//Rotas de experiencias
Route::get('/experiencias', [ExperienciaController::class,'all']);
Route ::get('/experiencias/{id_experiencia}', [ExperienciaController::class, 'show']);
Route ::post('/experiencias', [ExperienciaController::class, 'store']);
Route::put('/experiencias/{id_experiencia}', [ExperienciaController::class,'update']);
Route::delete('/experiencias/{id_experiencias}', [ExperienciaController::class,'destroy']);

//Route de vagas
Route::post('/cadVagas', [VagaController::class, 'store']);
Route::get('/vagas/{id_vagas}', [VagaController::class, 'show']);
Route::get('/vagasShowAll', [VagaController::class, 'showAll']);
Route::delete('/vagas/{id_vagas}', [VagaController::class,'destroy']);
Route::put('/vagas/{id_vagas}', [VagaController::class,'update']);

//Route da habilidades + vagas (relação N pra N)
Route::post('/habOnVagas/{id_habilidades}/{id_vagas}', [VagaController::class, 'adicionarHabilidades']); //adicionar habilidades nas vagas
Route::get('/habOnVagas/{id_vagas}', [VagaController::class, 'verHabilidades']); 

//Route da pessoa fisica + vagas (relação N pra N)
Route::post('/candidatar/{id_pessoas}/{id_vagas}', [VagaController::class, 'candidatarPessoas']); //adicionar pessoa fisica nas vagas
Route::get('/candidatosOnVagas/{id_vagas}', [VagaController::class, 'verCandidatos']);

//Relação de habilidades com pessoas físicas N pra N
Route::post('/habOnCandidato/{id_habilidades}/{id_pessoas}', [PessoasFisicaController::class, 'adicionarHabilidades']);
Route::get('/habOnCandidato/{id_pessoas}', [PessoasFisicaController::class, 'verHabilidades']);

//Route de habiliades
Route::post('/cadHabilidades', [HabilidadeController::class, 'store']);

//Route de cidades
Route::post('/cadCidades', [CidadeController::class,'store']);
Route::get('/cidades/{id_cidades}', [CidadeController::class,'show']);
Route::get('/cidadesShowAll', [CidadeController::class, 'showAll']);
Route::delete('/cidades/{id_cidades}', [CidadeController::class,'destroy']);
Route::put('/cidades/{id_cidades}', [CidadeController::class,'update']);

/* Route de endereços que tá junto do de pessoas
Route::post('/cadEnderecos', [EnderecoController::class,'store']);
Route::get('/enderecos/{id_enderecos}', [EnderecoController::class,'show']);
Route::delete('/enderecos/{id_enderecos}', [EnderecoController::class,'destroy']);
Route::put('/enderecos/{id_enderecos}', [EnderecoController::class,'update']);
*/

Route::get('/enderecoShowAll', [EnderecoController::class, 'showAll']);

//Route de pessoas
Route::post('/cadPessoas', [PessoaController::class, 'store']); //o controller de pessoas faz o store de pessoas, empresas e usuários
Route::get('/pessoas/{id_pessoas}', [PessoaController::class, 'show']); //o controller de pessoas faz o show de pessoas, empresas e usuários
Route::delete('/pessoas/{id_pessoas}', [PessoaController::class, 'destroy']); //o controller de pessoas faz o delete de pessoas, empresas e usuários
Route::put('/pessoas/{id_pessoas}', [PessoaController::class, 'update']);  //o controller de pessoas faz o update de pessoas, empresas e usuários

