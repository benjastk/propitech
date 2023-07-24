<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodos_pagos';
    protected $primaryKey = 'idMetodosPagos';
    protected $fillable = [
        'nombreMetodoPago',
        'created_at',
        'updated_at'
    ];
}
