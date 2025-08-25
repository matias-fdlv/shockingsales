<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'Mail' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['Mail' => $request->Mail, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/personas');
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
        return redirect('/login');
    }

    public function username()
    {
        return 'Mail';
    }
}