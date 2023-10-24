<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoPago extends Model
{
    protected $table = 'estados_pagos';
    protected $primaryKey = 'idEstadoPago';
    protected $fillable = [
        'idContrato',
        'token',
        'fechaVencimiento',
        'arriendoMensual',
        'numeroCuota',
        'idEstado',
        'garantia',
        'garantiaDos',
        'comision',
        'saldo',
        'subtotal',
        'totalPagado',
        'saldoAnterior',
        'creadoPor',
        'notas',
        'editado',
        'created_at',
        'updated_at'
    ];
}
