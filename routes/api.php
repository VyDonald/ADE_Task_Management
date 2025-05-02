<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\UtilisateurController;





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('utilisateurs')->group(function () {
    Route::get('/', [UtilisateurController::class, 'index']);
    Route::post('/', [UtilisateurController::class, 'store']);
    Route::get('/{utilisateur}', [UtilisateurController::class, 'show']);
    Route::put('/{utilisateur}', [UtilisateurController::class, 'update']);
    Route::delete('/{utilisateur}', [UtilisateurController::class, 'destroy']);
});

Route::prefix('equipes')->group(function () {
    Route::get('/', [EquipeController::class, 'index']);
    Route::post('/', [EquipeController::class, 'store']);
    Route::get('/{equipe}', [EquipeController::class, 'show']);
    Route::put('/{equipe}', [EquipeController::class, 'update']);
    Route::delete('/{equipe}', [EquipeController::class, 'destroy']);
});

Route::prefix('projets')->group(function () {
    Route::get('/', [ProjetController::class, 'index']);
    Route::post('/', [ProjetController::class, 'store']);
    Route::get('/{projet}', [ProjetController::class, 'show']);
    Route::put('/{projet}', [ProjetController::class, 'update']);
    Route::delete('/{projet}', [ProjetController::class, 'destroy']);
});

Route::prefix('taches')->group(function () {
    Route::get('/', [TacheController::class, 'index']);
    Route::post('/', [TacheController::class, 'store']);
    Route::get('/{tache}', [TacheController::class, 'show']);
    Route::put('/{tache}', [TacheController::class, 'update']);
    Route::delete('/{tache}', [TacheController::class, 'destroy']);
});