<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Users\UserDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterUsuarioController
{
    public function mostrarFormularioUsuario()
    {
        return view('registro.registro-usuario');
    }

    public function RegistrarUsuario(Request $request, UserDataService $service)
    {
        $validated = $request->validate([
            'Nombre'   => 'required|string|max:255',
            'Mail'     => 'required|email|unique:personas,Mail',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear persona + fila en usuario (sin iniciar sesión todavía)
        $persona = $service->registrarUsuario(
            nombre: $validated['Nombre'],
            mail: $validated['Mail'],
            passwordPlano: $validated['password']
        );

        // Iniciar sesión (guard por defecto) y regenerar la sesión por seguridad
        Auth::login($persona);
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', '¡Usuario registrado con éxito!');
    }
}
