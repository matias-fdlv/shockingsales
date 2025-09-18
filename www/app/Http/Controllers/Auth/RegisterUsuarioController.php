<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterUsuarioController
{
    public function showRegistrationForm()
    {
        return view('registro.registro-usuario');
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

        // 👇 Insertamos en tabla usuario
        Usuario::create([
            'IDPersona' => $persona->IDPersona
        ]);

        Auth::login($persona);

        return redirect()->route('home')->with('success', '¡Usuario registrado con éxito!');
    }
}
