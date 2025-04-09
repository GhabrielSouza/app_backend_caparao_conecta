<?php

use App\Http\Controllers\ExperienciaController;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return 'Status OK';
});


//Rotas de experiencias
Route::get('/experiencias', [ExperienciaController::class,'all']);
Route ::get('/experiencias/{id_experiencia}', [ExperienciaController::class, 'show']);
Route ::post('/experiencias', [ExperienciaController::class, 'store']);
Route::put('/experiencias/{id_experiencia}', [ExperienciaController::class,'update']);
Route::delete('/experiencias/{id_experiencias}', [ExperienciaController::class,'destroy']);