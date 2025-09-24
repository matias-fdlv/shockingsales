<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController
{
    public function showLoginForm()
    {
        return view('auth.login'); // formulario de login
    }

    public function login(Request $request)
    {
        $request->validate([
            'Mail' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['Mail' => $request->Mail, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();

            $persona = Auth::user(); // guard web

            // Si es admin: inicia tambien la sesión en el guard admin y redirige al home de admin
            if ($persona->admin) {
                // Inicia la sesión admin con el mismo usuario
                Auth::guard('admin')->login($persona, (bool)$request->remember);

                return redirect()->route('home');
            }

            // Si es usuario común: al home
            if ($persona->usuario) {
                return redirect()->route('home');
            }

            // Sin rol válido
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'Mail' => 'Tu cuenta no tiene rol válido.',
            ]);
        }

        throw ValidationException::withMessages([
            'Mail' => __('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        // Cerrar ambos tipos de sesiones
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
