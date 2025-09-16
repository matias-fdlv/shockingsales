<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'IDCategoria';
    public $timestamps = false;
    protected $fillable = ['Nombre'];

    public function productos()
    {
        // Pivot: pertenece(IDProductoI, IDCategoria)
        return $this->belongsToMany(ProductoInterno::class, 'pertenece', 'IDCategoria', 'IDProductoI');
    }
}

