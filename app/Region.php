<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'region';
    protected $fillable = [
        'id',
        'nombre',
        'ISO_3166_2_CL',
        'idPais',
        'conCobertura',
        'latitudRegion',
        'longitudRegion'
    ];
}
