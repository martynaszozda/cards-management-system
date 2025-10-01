<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cards', [CardController::class, 'index']);
    Route::post('/cards', [CardController::class, 'store']);
    Route::get('/cards/{card}', [CardController::class, 'show']);
    Route::put('/cards/{card}', [CardController::class, 'update']);
    Route::delete('/cards/{card}', [CardController::class, 'destroy']);
});