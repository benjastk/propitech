<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioCuentaBancaria extends Model
{
    protected $table = 'usuarios_cuentas_bancarias';
    protected $primaryKey = 'idUsuarioCuentaBancaria';
    protected $fillable = [  
        'idUsuario',
        'idBanco',
        'idTipoCuenta',
        'numeroCuenta',
        'correoAsociado',
        'observaciones',
        'created_at',
        'updated_at'
    ];
}
