<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaPropiedad extends Model
{
    protected $table = 'reservas_propiedades';
    protected $primaryKey = 'idReserva';
    protected $fillable = [
        'idPropiedad',
        'idEstado',
        'token',
        'numeroTransaccion',
        'fechaDePago',
        'nombre',
        'apellido',
        'rut',
        'telefono',
        'email',
        'identificadorUnico',
        'valorReserva',
        'direccion',
        'numero',
        'departamento',
        'idPais',
        'idRegion',
        'idProvincia',
        'idComuna',
        'comuna',
        'region',
        'creadoPor',
        'created_at',
        'updated_at'
    ];
}
