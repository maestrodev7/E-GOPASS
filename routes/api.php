<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\CheckIfSupperAdmin;
use App\Http\Middleware\CheckIfAdmin;
use App\Http\Controllers\Api\AdminController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('request-reset-password', [AuthController::class, 'requestResetPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);


Route::middleware(['auth:sanctum', CheckIfSupperAdmin::class])->get('/admins', [AdminController::class, 'getAllAdmins']);
Route::middleware(['auth:sanctum', CheckIfSupperAdmin::class])->get('/admins/{id}', [AdminController::class, 'getAdminById']);
Route::middleware(['auth:sanctum', CheckIfSupperAdmin::class])->post('/admins', [AdminController::class, 'createAdmin']);
Route::middleware(['auth:sanctum', CheckIfSupperAdmin::class])->delete('/admins/{id}', [AdminController::class, 'deleteAdmin']);