<?php
// app/Services/Users/UserDataService.php
namespace App\Services\Users;

use App\Models\Persona;
use App\Models\Administrador;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserDataService
{
    /**
     * Crea Persona + Administrador (Eloquent por ahora) y devuelve el modelo Persona.
     */
    public function registrarAdmin(string $nombre, string $mail, string $passwordPlano, int $estado = 1, ?string $secretKey = null): Persona
    {
        $hash = Hash::make($passwordPlano);
        
        try {
            $rows = DB::select('CALL altaAdmin(?, ?, ?)', [$nombre, $mail, $hash]);

            $id = (int)($rows[0]->IDPersona ?? 0);
            return Persona::findOrFail($id);


        } catch (Throwable $e) {
            // Podés mapear 'Mail ya registrado' a error de validación si querés
            throw $e;
        }
    }

    /**
     * Crea Persona + Usuario (Eloquent por ahora) y devuelve el modelo Persona.
     */
    public function registrarUsuario(string $nombre, string $mail, string $passwordPlano, int $estado = 1, ?string $secretKey = null): Persona
    {
        $hash = Hash::make($passwordPlano);

     
        try {
            $rows = DB::select('CALL altaUsuario(?, ?, ?)', [$nombre, $mail, $hash]);

            $id = (int)($rows[0]->IDPersona ?? 0);
            return Persona::findOrFail($id);


        } catch (Throwable $e) {
            // Podés mapear 'Mail ya registrado' a error de validación si querés
            throw $e;
        }
    }
}
