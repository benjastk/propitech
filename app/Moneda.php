<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    protected $table = 'tipos_monedas';
    protected $primaryKey = 'idMoneda';
    protected $fillable = [
        'nombreMoneda',
        'created_at',
        'updated_at'
    ];
}
