<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    protected $table = 'tipos_usuarios';
    protected $fillable = [
        'idTipoUsuario',
        'notas',
        'nombreTipoUsuario'
    ];
}
