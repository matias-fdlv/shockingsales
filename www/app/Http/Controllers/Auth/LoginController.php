<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'Mail'     => 'required|email',
            'password' => 'required',
        ]);


        $persona = Persona::where('Mail', $request->Mail)->first();

        // Verificación para ver si la cuenta está activa o no.

        if ($persona && strtolower(trim((string)$persona->Estado)) !== 'activo') {
            return redirect()
                ->route('login')
                ->withErrors(['Mail' => 'Tu cuenta está desactivada. Contacta al administrador.'])
                ->withInput($request->only('Mail', 'remember'));
        }

        if (Auth::attempt(['Mail' => $request->Mail, 'password' => $request->password], (bool)$request->remember)) {
            $request->session()->regenerate();

            $persona = Auth::user();

            // Si es admin
            if ($persona->admin) {
                Auth::guard('admin')->login($persona, (bool)$request->remember);
                return redirect()->route('home');
            }

            // Si es usuario 
            if ($persona->usuario) {
                return redirect()->route('home');
            }

            // Sin rol válido muestra este mensaje
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'Mail' => 'Tu cuenta no tiene rol válido.',
            ]);
        }

        throw ValidationException::withMessages([
            'Mail' => __('auth.failed'),
        ]);
    }


    //Función para cerrár sesión
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


    public function username()
    {
        return 'Mail';
    }
}
