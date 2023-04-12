<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
    protected $table = 'comuna';
    protected $fillable = [
        'id',
        'nombre',
        'idProvincia',
        'conCobertura',
        'codigoComuna',
        'prioridadOrden',
        'fotoComuna',
        'latitudComuna',
        'longitudComuna',
        'created_at',
        'updated_at'
    ];
}
