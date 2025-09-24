<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//categoria de cada producto.
class Categoria extends Model

{
    //tabla a usar
    protected $table = 'categorias';

    //primarykey de la tabla
    protected $primaryKey = 'IDCategoria';

    //fillables
    public $timestamps = false;

    protected $fillable = ['Nombre'];

    //belongstomany, a traves de una relacion con la tabla pertenece hacemos un N a N, muchas Categorias pertenecen a muchos ProductosInternos
    public function productos()

    {
        return $this->belongsToMany(ProductoInterno::class, 'pertenece', 'IDCategoria', 'IDProductoI');

    }

}
