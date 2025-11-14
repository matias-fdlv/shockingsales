<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Persona extends Authenticatable
{
    // HasFactory: habilita Persona::factory() para tests/seeders
    // Notifiable: permite enviar notificaciones (mail, etc.) a la persona
    // A considerar parar el futuro
    use HasFactory, Notifiable;

    protected $table = 'personas';
    protected $primaryKey = 'IDPersona';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Estado',
        'Nombre',
        'Mail',
        'Password',
        'SecretKey',
    ];

    // Campos ocultos
    protected $hidden = [
        'Password',
        'remember_token',
        'SecretKey',
    ];

    //Casts de atributos. Transforman automáticamente los valores al leer/guardar desde/ hacia la base de datos.
    protected function casts(): array
    {
        return [
            'Password'  => 'hashed', //La contraseña se hashea automaticamente
            'SecretKey' => 'encrypted',//La secretkey se encripta automaticamente
        ];
    }

    /*
     |--------------------------------------------------------------------------
     | Relaciones
     |--------------------------------------------------------------------------
     */

    public function admin()
    {
        return $this->hasOne(Administrador::class, 'IDPersona', 'IDPersona');
    }

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'IDPersona', 'IDPersona');
    }

    /*
     |--------------------------------------------------------------------------
     | Scopes los para los Services
     |--------------------------------------------------------------------------
     */

    /**
     * Para buscar los usuarios Usuarios.
     */
    public function scopeConUsuario($query)
    {
        return $query->has('usuario')->with('usuario');
    }

    /**
     * Personas con Estado = Activo
     */
    public function scopeActivos($query)
    {
        return $query->where('Estado', 'Activo');
    }
}
