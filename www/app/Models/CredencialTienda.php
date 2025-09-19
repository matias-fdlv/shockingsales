<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//credencialtienda es donde (supuestamente) guardaremos las token y la informacion necesaria para acceder a la API (???)
class CredencialTienda extends Model
{
    protected $table = 'credencialesTienda';
    protected $primaryKey = 'IDCredencial';
    public $timestamps = false;
    protected $fillable = ['IDTienda', 'Tipo', 'Valor'];

    public function tienda()
    {
        return $this->belongsTo(Tienda::class, 'IDTienda', 'IDTienda');
    }
}
