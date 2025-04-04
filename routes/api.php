<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VagaController;
use App\Http\Controllers\PessoaController;

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

Route::apiResource('candidato',VagaController::class);

Route::apiResource('usuario', UsuarioController::class);

Route::apiResource('pessoa', PessoaController::class);

Route::post('/cadPessoas', [PessoaController::class, 'store']); //o controller de pessoas faz o store de pessoas, empresas e usuários
Route::get ('/pessoas/{id_pessoas}', [PessoaController::class, 'show']); //o controller de pessoas faz o show de pessoas, empresas e usuários
Route::delete ('/pessoas/{id_pessoas}', [PessoaController::class, 'destroy']); //o controller de pessoas faz o delete de pessoas, empresas e usuários
Route::put('/pessoas/{id_pessoas}', [PessoaController::class,'update']);  //o controller de pessoas faz o update de pessoas, empresas e usuários

