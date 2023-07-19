<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCuentaBancaria extends Model
{
    protected $table = 'tipos_cuentas_bancos';
    protected $primaryKey = 'idTipoCuenta';
    protected $fillable = [
        'nombreTipoCuenta'
    ];
}
