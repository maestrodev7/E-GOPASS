<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\CheckIfSupperAdmin;
use App\Http\Middleware\CheckIfAdmin;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('request-reset-password', [AuthController::class, 'requestResetPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::middleware(['auth:sanctum', CheckIfSupperAdmin::class])->get('/admin-only', function () {
    return response()->json(['message' => 'You are an admin and have access to this route.']);
});