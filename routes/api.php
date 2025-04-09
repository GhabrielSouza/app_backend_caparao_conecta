<?php

use App\Http\Controllers\ExperienciaController;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return 'Status OK';
});

Route ::get('/experiencias', [ExperienciaController::class, 'all']);