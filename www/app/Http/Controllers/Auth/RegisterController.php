<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'Estado' => 'nullable|string',
            'Nombre' => 'required|string|max:255',
            'Mail' => 'required|email|unique:personas,Mail',
            'password' => 'required|string|min:8|confirmed',
            'SecretKey' => 'nullable|string',
        ]);

        $persona = Persona::create([
            'Estado' => $request->Estado,
            'Nombre' => $request->Nombre,
            'Mail' => $request->Mail,
            'password' => Hash::make($request->password),
            'SecretKey' => $request->SecretKey,
        ]);

        Auth::login($persona);

        return redirect('/personas')->with('success', '¡Registro exitoso!');
    }
}
