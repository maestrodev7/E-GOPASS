<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\CheckIfSupperAdmin;
use App\Http\Middleware\CheckIfAdmin;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AgentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('request-reset-password', [AuthController::class, 'requestResetPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::middleware(['auth:sanctum', CheckIfSupperAdmin::class])->get('/agents', [AgentController::class, 'getAllAgents']);
Route::middleware(['auth:sanctum', CheckIfSupperAdmin::class])->get('/agents/{id}', [AgentController::class, 'getAgentById']);
Route::middleware(['auth:sanctum', CheckIfSupperAdmin::class])->post('/agents', [AgentController::class, 'createAgent']);
Route::middleware(['auth:sanctum', CheckIfSupperAdmin::class])->delete('/agents/{id}', [AgentController::class, 'deleteAgent']);

Route::middleware(['auth:sanctum', CheckIfSupperAdmin::class])->get('/admins', [AdminController::class, 'getAllAdmins']);
Route::middleware(['auth:sanctum', CheckIfSupperAdmin::class])->get('/admins/{id}', [AdminController::class, 'getAdminById']);
Route::middleware(['auth:sanctum', CheckIfSupperAdmin::class])->post('/admins', [AdminController::class, 'createAdmin']);
Route::middleware(['auth:sanctum', CheckIfSupperAdmin::class])->delete('/admins/{id}', [AdminController::class, 'deleteAdmin']);