<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentaMensual extends Model
{
    protected $table = 'rentas_mensuales';
    protected $fillable = [
        'idRentaMensual',
        'nombreRentaMensual'
    ];
}
