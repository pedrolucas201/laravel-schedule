<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;

// Rota de login e registro
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('contact.index');
    Route::get('/contacts', [ContactController::class, 'index'])->name('contact.index'); // Agenda de contatos
    Route::get('/contacts/create', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/contacts/store', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/contacts/edit/{contact}', [ContactController::class, 'edit'])->name('contact.edit');
    Route::put('/contacts/update/{contact}', [ContactController::class, 'update'])->name('contact.update');
    Route::get('/contacts/show/{contact}', [ContactController::class, 'show'])->name('contact.show');
    Route::delete('/contacts/destroy/{contact}', [ContactController::class, 'destroy'])->name('contact.destroy');
    Route::get('/contacts/export', [ContactController::class, 'export'])->name('contact.export'); // Exportar para CSV
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

