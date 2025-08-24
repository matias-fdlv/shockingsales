<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    // Nombre de la tabla
    protected $table = 'personas';

    // Clave primaria personalizada
    protected $primaryKey = 'IDPersona';

    // Si la clave primaria es autoincremental
    public $incrementing = true;

    // Si la clave primaria es int
    protected $keyType = 'int';

    // datos
    protected $fillable = ['Nombre', 'Mail', 'Contraseña', 'SecretKey'];
}
