<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoTienda extends Model
{
    protected $table = 'productoTienda';
    protected $primaryKey = 'IDProductoT';
    public $timestamps = false;

    // ⚠️ Usa el nombre EXACTO de la columna: 'Afiliado' (no 'afiliado')
    protected $fillable = ['IDProductoI', 'Nombre', 'Precio', 'URL', 'Afiliado', 'FechaActualizacion'];

    // Valor por defecto para que jamás vaya NULL (tu columna es VARCHAR)
    protected $attributes = [
        'Afiliado' => '',
    ];

    // Cinturón y tirantes: si alguien intenta guardar NULL, lo forzamos a ''
    protected static function booted()
    {
        static::saving(function ($model) {
            if (!array_key_exists('Afiliado', $model->attributes) || is_null($model->attributes['Afiliado'])) {
                $model->attributes['Afiliado'] = '';
            }
        });
    }

    public function interno()
    {
        return $this->belongsTo(ProductoInterno::class, 'IDProductoI', 'IDProductoI');
    }

    public function tiendas()
    {
        return $this->belongsToMany(Tienda::class, 'tiene', 'IDProductoT', 'IDTienda');
    }
}
