<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'provincia';
    protected $fillable = [
        'id',
        'nombre',
        'idRegion',
        'conCobertura'
    ];
}
