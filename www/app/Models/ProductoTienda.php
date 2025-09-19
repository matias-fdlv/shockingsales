<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//aca se guarda el producto que se obtiene de las apis, teniendo id, nombre, precio, url afiliado y ultima fecha en la que obtuvimos los datos de este.
class ProductoTienda extends Model
{
    //tabla a usar de la bd
    protected $table = 'productoTienda';

    //primarykey de la tabla
    protected $primaryKey = 'IDProductoT';

    //fillables
    protected $fillable = ['IDProductoI', 'Nombre', 'Precio', 'URL', 'Afiliado', 'FechaActualizacion'];

    //afiliado debe tener un contenido si o si, en este caso se le da un espacio en blanco para evitar NULL
    protected $attributes = [
        'Afiliado' => '',
    ];

    //este es una funcion de tipo BOOTED, al guardar el modelo, se ejecuta.
    //se asegura de que afiliado no sea null en ningun caso
    protected static function booted()
    {
        static::saving(function ($model) {
            //si afiliado is null, lo convierte en un espacio en blanco
            if (!array_key_exists('Afiliado', $model->attributes) || is_null($model->attributes['Afiliado'])) {
                $model->attributes['Afiliado'] = '';
            }
        });
    }

    //muchos productostienda pertenecen a 1 producto interno
    public function interno()
    {
        return $this->belongsTo(ProductoInterno::class, 'IDProductoI', 'IDProductoI');

    }

    //muchos productostiendas pertenecen a muchas tiendas y lo mismo al reves, es N a N y usa tiene como relacion entre ambos.
    public function tiendas()
    {
        return $this->belongsToMany(Tienda::class, 'tiene', 'IDProductoT', 'IDTienda');
    }
}
