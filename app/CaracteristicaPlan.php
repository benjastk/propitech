<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaracteristicaPlan extends Model
{
    protected $table = 'caracteristicas_planes';
    protected $primaryKey = 'idCaracteristica';
    protected $fillable = [
        'nombreCaracteristica',
        'created_at',
        'updated_at'
    ];
}
