<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaracteristicasPorPropiedades extends Model
{
    protected $table = 'caracteristicas_por_propiedades';
    protected $fillable = [
        'id',
        'idPropiedad',
        'idCaracteristicaPropiedad',
        'created_at',
        'updated_at'
    ];
}
