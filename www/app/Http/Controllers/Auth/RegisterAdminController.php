<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterAdminController
{
    public function showRegistrationForm()
    {
        return view('registro.registro-admin');
    }

    public function register(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:255',
            'Mail' => 'required|email|unique:personas,Mail',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $persona = Persona::create([
            'Estado' => 1,
            'Nombre' => $request->Nombre,
            'Mail' => $request->Mail,
            'password' => Hash::make($request->password),
        ]);

        // 👇 Insertamos en tabla administrador
        Administrador::create([
            'IDPersona' => $persona->IDPersona
        ]);

        Auth::login($persona);

        return redirect()->route('VistaAdmin.homeAdmin')->with('success', '¡Administrador registrado con éxito!');
    }
}
