<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentoReserva extends Model
{
    protected $table = 'documentos_pagos_reservas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idReserva',
        'tokenReserva',
        'idPago',
        'idTipoDocumento',
        'rutaDocumento',
        'subidoPor',
        'created_at',
        'updated_at'
    ];
}
