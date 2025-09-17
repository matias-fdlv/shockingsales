<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'IDPersona';
    public $timestamps = false;

    protected $fillable = ['IDPersona'];
}
