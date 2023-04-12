<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';
    protected $fillable = [
        'idEstado',
        'nombreEstado',
        'idTipoEstado',
        'idUsuarioPropietarioEstado',
        'idEstadoDependiente',
        'idColorEstado'
    ];
        
}
