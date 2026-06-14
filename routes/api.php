<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Routes publiques : inscription et connexion.
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées : nécessitent un token valide.
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});
