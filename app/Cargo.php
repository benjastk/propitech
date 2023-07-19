<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargos';
    protected $primaryKey = 'idCargo';
    protected $fillable = [
        'idEstadoPago',
        'nombreCargo',
        'descripcionCargo',
        'idEstado',
        'montoCargo',
        'correspondeA',
        'cargoValidado',
        'creadoPor',
        'created_at',
        'updated_at'
    ];
}
