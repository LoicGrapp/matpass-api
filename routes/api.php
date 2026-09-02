<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\CreneauController;
use App\Http\Controllers\EspaceController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Routes publiques : inscription et connexion.
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées : nécessitent un token valide.
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Lecture accessible à tout utilisateur connecté (utile au planning).
    Route::get('/espaces', [EspaceController::class, 'index']);
    Route::get('/cours', [CoursController::class, 'index']);
    Route::get('/creneaux', [CreneauController::class, 'index']);

    // Réservations de l'utilisateur connecté.
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy']);
    // Le QR code présenté au coach pour valider sa présence.
    Route::get('/reservations/{reservation}/qr', [ReservationController::class, 'qr']);

    // Réservé aux coachs : leur liste d'appel et le scan des présences.
    Route::middleware('role:coach')->group(function () {
        Route::get('/creneaux/{creneau}/reservations', [CreneauController::class, 'reservations']);
        Route::post('/presences', [PresenceController::class, 'store']);
    });

    // Réservé aux administrateurs.
    Route::middleware('role:admin,super_admin')->group(function () {
        // Gestion des utilisateurs.
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::patch('/users/{user}', [UserController::class, 'update']);

        // Gestion des espaces.
        Route::post('/espaces', [EspaceController::class, 'store']);

        // Gestion des cours.
        Route::post('/cours', [CoursController::class, 'store']);

        // Gestion des créneaux.
        Route::post('/creneaux', [CreneauController::class, 'store']);
    });
});
