<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogTransaccion extends Model
{
    protected $table = 'log_transacciones';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tipoTransaccion',
        'idUsuario',
        'webclient',
        'descripcionTransaccion',
        'created_at',
        'updated_at'
    ];
}
