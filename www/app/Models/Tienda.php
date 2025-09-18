<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//este archivo encapsula la tienda, la cual podria ser mercado libre o aliexpress por ejemplo.
//cuenta con los datos importantes de estas tiendas como el nombre, el id, el estado y api que es para ???
class Tienda extends Model
{
    //llamar a la tabla tienda de la bd
    protected $table = 'tienda';

    //se setea que la primarykey de tienda es IDTIenda (tal como esta en la BD)
    protected $primaryKey = 'IDTienda';

    //campos fillables, o sea, llenables en la BD!. unica y exclusivamente estos.
    protected $fillable = ['Nombre', 'API', 'Estado'];

    //esta funcion tiene la cardinalidad 1 a N (hasmany), lo que significa, es que muchas credencialestienda tenen una idtienda. esto se puede ver mejor en Credencialienda.php
    public function credenciales()
    {
        return $this->hasMany(CredencialTienda::class, 'IDTienda', 'IDTienda');
    }

    //esta funcion tiene la cardinalidad N a N (belongstomany), y esta funcion hace referencia a la tabla tiene.
    //esta tabla se conecta tanto con IDTienda como con IDProductoT y especifica que un producto (idproductot) puede estar en muchas tiendas y lo mismo al reves, una tienda (idtienda) puede tener muchos productos.
    //A diferencia de la anterior funcion, esta requiere una relacion, en este caso, TIENE.
    public function productosTienda()
    {
        return $this->belongsToMany(ProductoTienda::class, 'tiene', 'IDTienda', 'IDProductoT');
    }
}

