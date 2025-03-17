<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Rota de registro via API
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Rota de login via API
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Rota de logout via API
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Exemplo de rota protegida, requer autenticação com Sanctum ou outro método de token
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
