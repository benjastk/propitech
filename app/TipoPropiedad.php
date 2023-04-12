<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPropiedad extends Model
{
    protected $table = 'tipos_propiedades';
    protected $fillable = [
        'idTipoPropiedad',
        'nombreTipoPropiedad'
    ];
}
