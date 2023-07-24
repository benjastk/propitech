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
        'created_at',
        'updated_at'
    ];
}
