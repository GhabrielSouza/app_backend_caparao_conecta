<?php

use App\Http\Controllers\Formacao_AcademicaController;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return 'Status OK';
});


//Rotas de formacoes academicas
Route::get('/formacoes_academicas', [Formacao_AcademicaController::class,'all']);
Route ::get('/formacoes_academicas/{id_experiencia}', [Formacao_AcademicaController::class, 'show']);
Route ::post('/formacoes_academicas', [Formacao_AcademicaController::class, 'store']);
Route::put('/formacoes_academicas/{id_experiencia}', [Formacao_AcademicaController::class,'update']);
Route::delete('/formacoes_academicas/{id_experiencias}', [Formacao_AcademicaController::class,'destroy']);