<?php

use App\Http\Controllers\CidadeController;
use App\Http\Controllers\EnderecoController;

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\CandidatoController;

use App\Http\Controllers\VagaController;
use App\Http\Controllers\HabilidadeController;

use App\Models\Endereco;
use App\Models\Habilidade;
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

//Route de vagas
Route::post('/cadVagas', [VagaController::class, 'store']);
Route::get('/vagas/{id_vagas}', [VagaController::class, 'show']);
Route::get('/vagasShowAll', [VagaController::class, 'showAll']);
Route::delete('/vagas/{id_vagas}', [VagaController::class,'destroy']);
Route::put('/vagas/{id_vagas}', [VagaController::class,'update']);

//Route da habilidades + vagas (relação N pra N)
Route::post('/habOnVagas/{id_habilidades}/{id_vagas}', [VagaController::class, 'adicionarHabilidades']); //vai pro controller das vagas
Route::get('/habOnVagas/{id_vagas}', [VagaController::class, 'verHabilidades']);



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

