<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterUsuarioController;
use App\Http\Controllers\Auth\RegisterAdminController;

// Ruta principal de la página (guest + usuario normal)
Route::get('/', function () {
    return view('home'); // resources/views/home.blade.php
})->name('home');

// Rutas públicas (solo guest)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Registro de Usuario
    Route::get('registro/usuario', [RegisterUsuarioController::class, 'showRegistrationForm'])->name('registro.usuario');
    Route::post('registro/usuario', [RegisterUsuarioController::class, 'register']);

    // Registro de Admin
    Route::get('registro/admin', [RegisterAdminController::class, 'showRegistrationForm'])->name('registro.admin');
    Route::post('registro/admin', [RegisterAdminController::class, 'register']);
});

// Logout
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard exclusivo de admin
Route::get('/admin/dashboard', function () {
    return view('VistaAdmin.homeAdmin'); // resources/views/admin/dashboard.blade.php
})->name('VistaAdmin.homeAdmin')->middleware('auth');

// Rutas protegidas (comunes a cualquier usuario logueado)
Route::middleware('auth')->group(function () {
    Route::resource('personas', PersonaController::class);
});
