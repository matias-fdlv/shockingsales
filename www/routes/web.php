<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterUsuarioController;
use App\Http\Controllers\Auth\RegisterAdminController;

/*
|--------------------------------------------------------------------------
| Página principal (pública)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home'); 
})->name('home');

/*
|--------------------------------------------------------------------------
| Rutas de USUARIO (guard: web)
|--------------------------------------------------------------------------
*/

// Invitados (no logueados)
Route::middleware('guest')->group(function () {

    // Login (form + post)
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Registro de Usuario
    Route::get('registro/usuario', [RegisterUsuarioController::class, 'mostrarFormularioUsuario'])
        ->name('registro.usuario');
    Route::post('registro/usuario', [RegisterUsuarioController::class, 'RegistrarUsuario']);
});

// Logout usuario (guard web)
Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth:web');

// Rutas protegidas para usuario (guard web)
Route::middleware('auth:web')->group(function () {
    Route::resource('personas', PersonaController::class);

    // Registro de Admin (si lo manejás desde el panel del usuario)
    Route::get('registro/admin', [RegisterAdminController::class, 'mostrarFormularioAdmin'])
        ->name('registro.admin');
    Route::post('registro/admin', [RegisterAdminController::class, 'RegistrarAdmin']);
});

/*
|--------------------------------------------------------------------------
| Rutas de ADMIN (guard: admin) — sesión separada
|--------------------------------------------------------------------------
*/

// Redirige el login admin al login general (reutilizamos el mismo formulario)
Route::get('/admin/login', fn () => redirect()->route('login'))->name('admin.login');

// Logout admin que cierra solo la sesión del guard admin
Route::post('/admin/logout', function () {
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    }
    return redirect()->route('login');
})->name('admin.logout');

// Área protegida del admin
Route::prefix('admin')->middleware(['auth:admin', 'admin'])->group(function () {

    // Dashboard admin 
    Route::get('/dashboard', function () {
        return view('VistaAdmin.homeAdmin'); 
    })->name('VistaAdmin.homeAdmin');

    //Administracion de Usuarios
Route::get('/dashboard/Administracion-De-Usuarios', [PersonaController::class, 'index'])
    ->name('Administracion-De-Usuarios');

});
