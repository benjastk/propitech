<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table ='pagos';
    protected $primaryKey = 'idPago';
    protected $fillable = [
        'idEstadoPago',
        'montoPago',
        'numeroTransaccion',
        'comentarios',
        'idMetodoPago',
        'tokenPago',
        'creadoPor',
        'metodoPagoOtrosPagos',
        'secuenciaTransaccion',
        'metodoPagoOtrosPagos',
        'tipoPago',
        'created_at',
        'updated_at'
    ];
}
