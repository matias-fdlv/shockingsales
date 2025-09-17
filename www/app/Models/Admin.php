<?php

namespace App\Models;

class Admin extends Persona
{
    // Relación con la tabla "administrador"
    public function administrador()
    {
        return $this->hasOne(Administrador::class, 'IDPersona', 'IDPersona');
    }
}
