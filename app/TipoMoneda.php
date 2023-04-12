<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMoneda extends Model
{
    protected $table = 'tipos_monedas';
    protected $fillable = [
        'idMoneda',
        'nombreMoneda',
        'created_at',
        'updated_at'
    ];
}
