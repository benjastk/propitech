<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaracteristicasPorProyectos extends Model
{
    protected $table = 'caracteristicas_por_proyecto';
    protected $fillable = [
        'id',
        'idProyecto',
        'idCaracteristicaPropiedad',
        'created_at',
        'updated_at'
    ];
}
