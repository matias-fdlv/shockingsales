<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController
{
    public function showLoginForm()
    {
        return view('auth.login'); // tu formulario de login
    }

    public function login(Request $request)
    {
        $request->validate([
            'Mail' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['Mail' => $request->Mail, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();

            $persona = Auth::user();

            // 🔹 Si está en la tabla administrador → va a dashboard admin
            if ($persona->admin) {
                return redirect()->route('VistaAdmin.homeAdmin');
            }

            // 🔹 Si está en la tabla usuario → va al home
            if ($persona->usuario) {
                return redirect()->route('home');
            }

            // Si no tiene rol válido, lo deslogueamos
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
