<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PerfilController
{
    /**
     * Mostrar el perfil del usuario autenticado.
     */
    public function mostrarPerfil(Request $request)
    {
        $user = $request->user(); // guard web
        return view('perfil.mostrar', compact('user'));
    }

    /**
     * Formulario de edición del perfil.
     */
    public function editarPerfil(Request $request)
    {
        $user = $request->user(); // guard web
        return view('perfil.editar', compact('user'));
    }

    /**
     * Actualizar: Nombre y/o Mail y/o Contraseña (opcional, parcial).
     */
   public function actualizarPerfil(Request $request)
{
    $user = $request->user();

    
    $norm = static function (?string $v) {
        if ($v === null) return null;
        $v = trim($v);
        return $v === '' ? null : $v;
    };

    $request->merge([
        'Nombre'                => $norm($request->input('Nombre')),
        'Mail'                  => $norm($request->input('Mail')),
        'password'              => $norm($request->input('password')),
        'password_confirmation' => $norm($request->input('password_confirmation')),
    ]);

    
    $validated = $request->validate([
        'Nombre'   => ['nullable', 'string', 'max:255'],
        'Mail'     => ['nullable', 'email', Rule::unique('personas', 'Mail')->ignore($user->getKey(), $user->getKeyName())],
        'password' => ['nullable', 'string', 'min:8', 'confirmed'],
    ]);

    
    $data = array_filter([
        'Nombre' => $validated['Nombre'] ?? null,
        'Mail'   => $validated['Mail']   ?? null,
    ], fn ($v) => !is_null($v));

    if (!empty($validated['password'])) {
        $data['password'] = Hash::make($validated['password']);
    }

    if (!empty($data)) {
        $user->forceFill($data)->save();
    }

    return redirect()
        ->route('perfil.mostrar')
        ->with('success', '¡Perfil actualizado correctamente!');
}

}
