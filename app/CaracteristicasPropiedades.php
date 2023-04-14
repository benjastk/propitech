<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaracteristicasPropiedades extends Model
{
    protected $table = 'caracteristicas_propiedades';
    protected $fillable = [
        'idCaracteristicaPropiedad',
        'nombreCaracteristica',
        'iTag',
        'created_at',
        'updated_at'
    ];
}
