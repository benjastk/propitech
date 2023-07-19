<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoFormulario extends Model
{
    protected $table = 'tipo_formulario';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombreFormulario',
        'created_at',
        'updated_at'
    ];
}
