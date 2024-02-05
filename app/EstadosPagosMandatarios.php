<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadosPagosMandatarios extends Model
{
    protected $table ='estados_pagos_mandatarios';

    protected $primaryKey = 'idEstadoPagoMandato';

    protected $fillable = [
        'idMandatoPropiedad',
        'idEstado',
        'idEstadoPago',
        'idContrato',
        'montoAPagar',
        'cargosAbonos',
        'montoPagado',
        'garantia',
        'montoComision',
        'aLiquidarSinDeuda',
        'montoALiquidarPropietario',
        'saldoArrastre',
        'editadoManual',
        'fechaDePago',
        'fechaLiquidado',
        'montoDeuda',
        'tieneTraspasoSaldo',
        'created_at',
        'updated_at'
    ];
}
