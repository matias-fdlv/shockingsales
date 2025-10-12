<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterUsuarioController;
use App\Http\Controllers\Auth\RegisterAdminController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PerfilController;
use App\Services\SearchService;


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
| Busqueda
|--------------------------------------------------------------------------
*/
// Rutas principales
// Ruta para procesar búsquedas (formulario tradicional)
Route::post('/buscar', [SearchController::class, 'search'])->name('search.execute');

// Ruta para ver resultados (por si alguien quiere compartir enlace)
Route::get('/buscar', [SearchController::class, 'search'])->name('search.results');


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


     Route::get('/perfil',         [PerfilController::class, 'mostrarPerfil'])->name('perfil.mostrar');
    Route::get('/perfil/editar',  [PerfilController::class, 'editarPerfil'])->name('perfil.editar');
    Route::put('/perfil',         [PerfilController::class, 'actualizarPerfil'])->name('perfil.actualizar');
});

/*
|--------------------------------------------------------------------------
| Rutas de ADMIN (guard: admin) — sesión separada
|--------------------------------------------------------------------------
*/

// Redirige el login admin al login general (reutilizamos el mismo formulario)
Route::get('/admin/login', fn() => redirect()->route('login'))->name('admin.login');

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


    Route::post('/personas/activar',   [PersonaController::class, 'activarCuenta'])->name('personas.activar');
    Route::post('/personas/desactivar', [PersonaController::class, 'desactivarCuenta'])->name('personas.desactivar');

    // Registro de Admin
    Route::get('registro/admin', [RegisterAdminController::class, 'mostrarFormularioAdmin'])
        ->name('registro.admin');
    Route::post('registro/admin', [RegisterAdminController::class, 'RegistrarAdmin']);
});
