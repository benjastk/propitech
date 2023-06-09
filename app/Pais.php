<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises';
    protected $fillable = [
        'idPais',
        'nombrePais',
        'conCobertura',
        'codigoPais',
        'created_at',
        'updated_at'
    ];
}
