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
     *
     * Tabla: personas
     * Columnas: Nombre, Mail, Contraseña
     */
    public function actualizarPerfil(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            // Si el campo viene en el request, se valida; si no viene, se ignora.
            'Nombre'      => ['sometimes', 'string', 'max:255'],
            'Mail'        => [
                'sometimes',
                'email',
                Rule::unique('personas', 'Mail')->ignore($user->getKey(), $user->getKeyName()),
            ],
            // Si quieres confirmación: agrega un input name="Contraseña_confirmation" en el form
            'password'  => ['sometimes', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [];

        if (array_key_exists('Nombre', $validated)) {
            $data['Nombre'] = $validated['Nombre'];
        }

        if (array_key_exists('Mail', $validated)) {
            $data['Mail'] = $validated['Mail'];
        }

        if (array_key_exists('password', $validated)) {
            // Hashear antes de guardar
            $data['password'] = Hash::make($validated['password']);
        }

        // Guardar evitando problemas de $fillable
        if (!empty($data)) {
            $user->forceFill($data)->save();
        }

        return redirect()
            ->route('perfil.mostrar')
            ->with('success', '¡Perfil actualizado correctamente!');
    }
}
