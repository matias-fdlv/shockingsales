<?php
namespace App\Services\Users;

use App\Models\Persona;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserDataService
{
    //Crea Persona + Administrador

    public function registrarAdmin(string $nombre, string $mail, string $passwordPlano, int $estado = 1, ?string $secretKey = null): Persona
    {
        $hash = Hash::make($passwordPlano);

        try {
            $rows = DB::select('CALL altaAdmin(?, ?, ?)', [$nombre, $mail, $hash]);

            $id = (int)($rows[0]->IDPersona ?? 0);
            return Persona::findOrFail($id);
        } catch (Throwable $e) {

            throw $e;
        }
    }

    //Crea Persona + Usuario 
    public function registrarUsuario(string $nombre, string $mail, string $passwordPlano, int $estado = 1, ?string $secretKey = null): Persona
    {
        $hash = Hash::make($passwordPlano);


        try {
            $rows = DB::select('CALL altaUsuario(?, ?, ?)', [$nombre, $mail, $hash]);

            $id = (int)($rows[0]->IDPersona ?? 0);
            return Persona::findOrFail($id);
        } catch (Throwable $e) {

            throw $e;
        }
    }


    //Activar Usuario
    public function activarUsuario($mail)
    {
        try {
            $rows = DB::select('CALL activarUsuario (?)', [$mail]);

        } catch (Throwable $e) {
            // Loguea $e->getMessage() si quieres
            return back()->with('error', 'Hubo un problema al activar el usuario');
        }
    }

    //Desactivar Usuario

public function desactivarUsuario(string $mail): RedirectResponse
{
    try {
        $rows = DB::select('CALL desactivarUsuario(?)', [$mail]);
        $msg = $rows[0]->message ?? 'Usuario desactivado';
        return back()->with('status', $msg);
    } catch (\Throwable $e) {
        // Muestra el error real del driver si está disponible
        $msg = $e->getMessage();
        if (property_exists($e, 'errorInfo') && is_array($e->errorInfo)) {
            $msg = ($e->errorInfo[2] ?? $msg) . (isset($e->errorInfo[1]) ? " (#{$e->errorInfo[1]})" : '');
        }
        return back()->with('error', $msg);
    }
}

}
