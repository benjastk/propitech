<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentoPago extends Model
{
    protected $table = 'documentos_pagos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idPropiedad',
        'idEstadoPago',
        'idPago',
        'idTipoDocumento',
        'rutaDocumento',
        'subidoPor',
        'validado',
        'created_at',
        'updated_at'
            ];
}
