<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogCorreoEnviado extends Model
{
    protected $table = 'log_correos_enviados';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre_tipo_correo',
        'usuario',
        'created_at',
        'updated_at'
    ];
}
