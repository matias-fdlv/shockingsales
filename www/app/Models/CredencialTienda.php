<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//credencialtienda es donde (supuestamente) guardaremos las token y la informacion necesaria para acceder a la API (???)
class CredencialTienda extends Model
{
    //tabla de la BD
    protected $table = 'credencialesTienda';

    //primarykey de la tabla
    protected $primaryKey = 'IDCredencial';

    //fillables de la tabla
    public $timestamps = false;
    protected $fillable = ['IDTienda', 'Tipo', 'Valor'];
    //esta funcion usa BELONGSTO, registro de credencialtienda (o sea, una token de una tienda) es parte de un registro de la tabla Tienda. no es una cardilanidad tan exacta, simplemente significa que credencial tienda, efectivamente, es de (belongs to) Tienda.
    public function tienda()
    {
        return $this->belongsTo(Tienda::class, 'IDTienda', 'IDTienda');
    }
}
