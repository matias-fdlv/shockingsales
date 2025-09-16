<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    protected $table = 'tienda';
    protected $primaryKey = 'IDTienda';
    public $timestamps = false;
    protected $fillable = ['Nombre', 'API', 'Estado'];

    public function credenciales()
    {
        return $this->hasMany(CredencialTienda::class, 'IDTienda', 'IDTienda');
    }

    public function productosTienda()
    {
        return $this->belongsToMany(ProductoTienda::class, 'tiene', 'IDTienda', 'IDProductoT');
    }
}

