<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    protected $table = 'descuentos';
    protected $primaryKey = 'idDescuento';
    protected $fillable = [
        'idEstadoPago',
        'nombreDescuento',
        'descripcionDescuento',
        'idEstado',
        'montoDescuento',
        'correspondeADescuentos',
        'creadoPor',
        'created_at',
        'updated_at'
    ];
}
