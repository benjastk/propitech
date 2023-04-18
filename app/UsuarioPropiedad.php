<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioPropiedad extends Model
{
    protected $table = 'usuario_propiedad';
    protected $fillable = [
        'id',
        'id_usuario',
        'id_propiedad',
        'created_at',
        'updated_at'
    ];
}
