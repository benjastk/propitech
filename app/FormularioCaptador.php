<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormularioCaptador extends Model
{
    protected $table = 'formulario_captador';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombrePropietario',
        'correoPropietario',
        'telefonoPropietario',
        'diaVisita',
        'direccionPropiedad',
        'tipoOperacion',
        'tipoPropiedad',
        'dormitorios',
        'banos',
        'estacionamiento',
        'bodega',
        'nombreCaptador',
        'rutCaptador',
        'telefonoCaptador',
        'isCaptador',
        'mensaje',
        'created_at',
        'updated_at'
    ];
}
