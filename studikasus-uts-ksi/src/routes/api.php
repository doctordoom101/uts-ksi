<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;

// Route::middleware('client.auth')->group(function (){
//     Route::get('/products', [ProductApiController::class, 'index']);
//     Route::post('/products', [ProductApiController::class, 'store']);
// });

Route::middleware('guru.auth')->group(function () {
    Route::get('/gurus', [GuruController::class, 'index']);
});