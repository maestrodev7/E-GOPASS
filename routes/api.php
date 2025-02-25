<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\CheckIfSupperAdmin;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\PrixController;

// Routes d'authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('request-reset-password', [AuthController::class, 'requestResetPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

// Middleware commun pour les super administrateurs
$superAdminMiddleware = ['auth:sanctum', CheckIfSupperAdmin::class];

// Groupe de routes pour les super administrateurs
Route::middleware($superAdminMiddleware)->group(function () {
    // Routes pour les administrateurs
    Route::prefix('admins')->group(function () {
        Route::get('/', [AdminController::class, 'getAllAdmins'])->name('admins.index');
        Route::get('/{id}', [AdminController::class, 'getAdminById'])->name('admins.show');
        Route::post('/', [AdminController::class, 'createAdmin'])->name('admins.store');
        Route::delete('/{id}', [AdminController::class, 'deleteAdmin'])->name('admins.destroy');
    });

    // Routes pour les agents
    Route::prefix('agents')->group(function () {
        Route::get('/', [AgentController::class, 'getAllAgents'])->name('agents.index');
        Route::get('/{id}', [AgentController::class, 'getAgentById'])->name('agents.show');
        Route::post('/', [AgentController::class, 'createAgent'])->name('agents.store');
        Route::delete('/{id}', [AgentController::class, 'deleteAgent'])->name('agents.destroy');
    });

    // Routes pour les prix
    Route::prefix('prix')->group(function () {
        Route::put('/', [PrixController::class, 'updatePrix'])->name('prix.update');
        Route::get('/{type}', [PrixController::class, 'getPrixByType'])->name('prix.show');
    });
});