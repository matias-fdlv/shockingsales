<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//en esta clase se guardan los productos de forma interna, de momento, no sabemos como usarlo exactamente.
//pueden guardarse para guardar productos predefinidos como playstation 1 o iphone 13 por ejemplo.
class ProductoInterno extends Model
{
    //tabla que usa de la bd
    protected $table = 'productoInternos';

    //clave primaria de la tabla usada
    protected $primaryKey = 'IDProductoI';

    //fillables
    protected $fillable = ['Nombre', 'Marca', 'Modelo'];

    //pertenece a muchos, N a N, usa una tabla para relacionarlos, pertenece.
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'pertenece', 'IDProductoI', 'IDCategoria');
    }


    //este es un 1 a N, cada productointerno (el modelo actual actual) tiene muchos productotienda.
    public function productosTienda()
    {
        return $this->hasMany(ProductoTienda::class, 'IDProductoI', 'IDProductoI');
    }
}
