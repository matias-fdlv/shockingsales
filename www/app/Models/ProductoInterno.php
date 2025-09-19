<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//en esta clase se guardan los productos de forma interna, de momento, no sabemos como usarlo exactamente.
//pueden guardarse para guardar productos predefinidos como playstation 1 o iphone 13 por ejemplo.
class ProductoInterno extends Model
{
    protected $table = 'productoInterno';
    protected $primaryKey = 'IDProductoI';
    public $timestamps = false;
    protected $fillable = ['Nombre', 'Marca', 'Modelo'];

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'pertenece', 'IDProductoI', 'IDCategoria');
    }

    public function productosTienda()
    {
        return $this->hasMany(ProductoTienda::class, 'IDProductoI', 'IDProductoI');
    }
}
