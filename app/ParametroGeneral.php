<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParametroGeneral extends Model
{
    protected $table = 'parametros_generales';
    protected $primaryKey = 'idParametroGeneral';
    protected $fillable = [
        'parametroGeneral',
        'valorParametro',
        'textoValorParametro',
        'notas',
        'created_at',
        'updated_at'
    ];
}
