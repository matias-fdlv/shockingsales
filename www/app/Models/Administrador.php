<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    protected $table = 'administrador';
    protected $primaryKey = 'IDPersona';
    public $timestamps = false;

    protected $fillable = ['IDPersona'];
}
