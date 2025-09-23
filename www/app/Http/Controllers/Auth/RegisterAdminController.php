<?php

namespace App\Http\Controllers\Auth;

use App\Services\Users\UserDataService;
use Illuminate\Http\Request;

class RegisterAdminController 
{
    public function mostrarFormularioAdmin()
    {
        return view('registro.registro-admin');
    }

    public function RegistrarAdmin(Request $request, UserDataService $service)
    {
        $validated = $request->validate([
            'Nombre'   => 'required|string|max:255',
            'Mail'     => 'required|email|unique:personas,Mail',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $service->registrarAdmin(
            nombre: $validated['Nombre'],
            mail: $validated['Mail'],
            passwordPlano: $validated['password'],
            estado: 1
        );

        return redirect()->route('registro.admin') 
            ->with('success', '¡Administrador creado. Ahora puede iniciar sesión!');
    }
}
