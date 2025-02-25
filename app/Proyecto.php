<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'proyectos';
    protected $primaryKey = 'idProyecto';
    protected $fillable = [
        'nombreProyecto', // title
        'valorUFDesde',
        'valorUFHasta',
        'dormitoriosDesde',
        'dormitoriosHasta',
        'baniosDesde',
        'baniosHasta',
        'tipoPropiedad', //type->name
        'latitud', //latitude
        'longitud',//longitude
        'idTipologia',
        'cantidadDepartamentos',
        'metrosDesde',
        'metrosHasta',
        'fotoProyecto',
        'direccion',
        'numero',
        'idPais',
        'idProvincia',
        'idRegion',//
        'idComuna',//zone->name
        'introduccion',
        'descripcion', //description
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
