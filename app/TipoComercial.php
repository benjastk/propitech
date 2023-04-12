<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoComercial extends Model
{
    protected $table = 'tipos_comerciales';
    protected $fillable = [
        'idTipoComercial',
        'nombreTipoComercial',
        'created_at',
        'updated_at'
    ];
}
