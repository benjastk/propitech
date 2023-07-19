<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormularioContacto extends Model
{
    protected $table = 'formulario_contacto';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_formulario',
        'nombre',
        'telefono',
        'email',
        'mensaje',
        'created_at',
        'updated_at'
    ];
}
