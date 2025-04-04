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

Route::apiResource('empresas',EmpresaController::class);

Route::apiResource('vaga',VagaController::class);

Route::post('/cadVagas', [VagaController::class, 'store']);



Route::apiResource('candidato',CandidatoController::class);

Route::apiResource('usuario', UsuarioController::class);

Route::apiResource('habilidade', HabilidadeController::class);

Route::post('/cadHabilidades', [HabilidadeController::class, 'store']);



Route::apiResource('cidade', CidadeController::class);

Route::post('/cadCidades', [CidadeController::class,'store']);
Route::get('/cidades/{id_cidades}', [CidadeController::class,'show']);
Route::delete('/cidades/{id_cidades}', [CidadeController::class,'destroy']);
Route::put('/cidades/{id_cidades}', [CidadeController::class,'update']);



Route::apiResource('endereco', EnderecoController::class);

Route::post('/cadEnderecos', [EnderecoController::class,'store']);
Route::get('/enderecos/{id_enderecos}', [EnderecoController::class,'show']);
Route::delete('/enderecos/{id_enderecos}', [EnderecoController::class,'delete']);
Route::put('/enderecos/{id_enderecos}', [EnderecoController::class,'update']);



Route::apiResource('pessoa', PessoaController::class);

Route::post('/cadPessoas', [PessoaController::class, 'store']); //o controller de pessoas faz o store de pessoas, empresas e usuários
Route::get ('/pessoas/{id_pessoas}', [PessoaController::class, 'show']); //o controller de pessoas faz o show de pessoas, empresas e usuários
Route::delete ('/pessoas/{id_pessoas}', [PessoaController::class, 'destroy']); //o controller de pessoas faz o delete de pessoas, empresas e usuários
Route::put('/pessoas/{id_pessoas}', [PessoaController::class,'update']);  //o controller de pessoas faz o update de pessoas, empresas e usuários

