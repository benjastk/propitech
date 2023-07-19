<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TiempoPagoGarantia extends Model
{
    protected $table = 'tiempos_pagos_garantias';
    protected $primaryKey = 'idTiempoPagoGarantia';
    protected $fillable = [
        'nombreTiempoPagoGaranti',
        'tiempo'
    ];
}
