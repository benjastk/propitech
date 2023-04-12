<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NivelUsoPropiedad extends Model
{
    protected $table = 'niveles_uso_propiedad';
    protected $fillable = [
        'idNivelUsoPropiedad',
        'nombreNivelUsoPropiedad',
        'created_at',
        'updated_at'
    ];
}
