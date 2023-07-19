<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormularioCanje extends Model
{
    protected $table = 'formulario_canjes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombreCorredor',
        'emailCorredor',
        'telefonoCorredor',
        'cantidadPropiedades',
        'tipoOperacion',
        'ciudadCorredor',
        'created_at',
        'updated_at'
    ];
}
