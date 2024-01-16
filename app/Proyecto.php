<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'proyectos';
    protected $primaryKey = 'idProyecto';
    protected $fillable = [
        'nombreProyecto',
        'valorUFDesde',
        'valorUFHasta',
        'dormitoriosDesde',
        'dormitoriosHasta',
        'baniosDesde',
        'baniosHasta',
        'tipoPropiedad',
        'latitud',
        'longitud',
        'idTipologia',
        'cantidadDepartamentos',
        'metrosDesde',
        'metrosHasta',
        'fotoProyecto',
        'direccion',
        'numero',
        'idPais',
        'idProvincia',
        'idRegion',
        'idComuna',
        'introduccion',
        'descripcion',
        'descripcion2',
        'entregaInmediata',
        'idDestacado',
        'creadoPor',
        'cercanoA',
        'idEstado',
        'created_at',
        'updated_at'
    ];
}
