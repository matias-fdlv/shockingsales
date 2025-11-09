<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    protected $table = 'tiendas';
    protected $primaryKey = 'IDTienda';

    protected $fillable = ['Nombre', 'API', 'Estado', 'BaseURL'];

    public function credenciales()
    {
        return $this->hasMany(CredencialTienda::class, 'IDTienda', 'IDTienda');
    }

    // getters
    public function getToken()
    {
        return $this->credenciales->where('Tipo', 'api_token')->first()->Valor ?? null;
    }
    public function getSecretKey()
    {
        return $this->credenciales->where('Tipo', 'secret_key')->first()->Valor ?? null;
    }


    //tiendas activas
    public function isActive()
    {
        return $this->Estado === 1 || $this->Estado === true;
    }
}