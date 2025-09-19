<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//categoria de cada producto.
class Categoria extends Model
{
    //tabla a usar
    protected $table = 'categoria';
    
    //primarykey de la tabla
    protected $primaryKey = 'IDCategoria';
 
    //fillables
    protected $fillable = ['Nombre'];

    //belongstomany, a traves de una relacion con la tabla pertenece hacemos un N a N, muchas Categorias pertenecen a muchos ProductosInternos
    public function productos()
    {
        return $this->belongsToMany(ProductoInterno::class, 'pertenece', 'IDCategoria', 'IDProductoI');
    }
}

