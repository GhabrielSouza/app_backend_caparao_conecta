<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VagaController;
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
