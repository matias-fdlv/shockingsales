<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Persona extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'personas';
    protected $primaryKey = 'IDPersona';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Estado',
        'Nombre',
        'Mail', 
        'password',
        'SecretKey',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}