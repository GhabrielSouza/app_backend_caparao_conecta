<?php

use App\Http\Controllers\empresaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\cadastrarController;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    try {
        DB::connection()->getPdo();
        echo'consegui conectarrr';
    }catch (\Exception $e) {
        echo 'error: '. $e->getMessage();
    }
});

Route::get('/login', [LoginController::class,'login']);

Route::get('/cadastrar', [cadastrarController::class,'cadastrar']);

Route::get('/candidato', [cadastrarController::class,'candidato']);
Route::get('/empresa', [empresaController::class,'empresa']);