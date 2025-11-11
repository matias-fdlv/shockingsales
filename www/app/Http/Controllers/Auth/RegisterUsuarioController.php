<?php

namespace App\Http\Controllers\Auth;

use App\Services\Users\UserDataService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterUsuarioController
{
    public function mostrarFormularioUsuario(): View
    {
        return view('registro.registro-usuario');
    }


   public function RegistrarUsuario(Request $request, UserDataService $service): RedirectResponse
{
    $validated = $request->validate([
        'Nombre'   => ['required', 'string', 'max:255'],
        'Mail'     => ['required', 'email', 'unique:personas,Mail'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    // Crea un usuario con los datos enviados 
    $persona = $service->registrarUsuario(
        nombre:        $validated['Nombre'],
        mail:          $validated['Mail'],
        passwordPlano: $validated['password']
    );

    return redirect()
        ->route('login') 
        ->with('success', 'Usuario registrado. Inicia sesión para continuar.');
}

}
