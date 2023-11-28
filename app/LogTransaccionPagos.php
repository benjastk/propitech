<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogTransaccionPagos extends Model
{
    protected $table = 'log_transacciones_pagos';
    protected $primaryKey = 'idLogTransaccionPago';
    protected $fillable = [
        'idPago',
        'nombreTransaccion',
        'numeroTransaccion',
        'webClient',
        'montoTransaccion',
        'idMetodoPago',
        'created_at',
        'updated_at'
    ];
}
