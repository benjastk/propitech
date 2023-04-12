<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColorEstado extends Model
{
    protected $table = 'colores_estados';
    protected $fillable = [
        'idColorEstado',
        'nombreColorEstado'
    ];
}
