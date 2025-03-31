<?php

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
