<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas_propiedades';
    protected $primaryKey = 'idVenta';
    protected $fillable = [
        'fechaInicio',
        'fechaCierre',
        'idPropiedad',
        'idUsuarioVendedor',
        'direccion',
        'numero',
        'block',
        'idPais',
        'idRegion',
        'idComuna',
        'idProvincia',
        'porcentajeComisionVendedor',
        'porcentajeComisionComprador',
        'precioVenta',
        'nombreComprador',
        'apellidoComprador',
        'rutComprador',
        'telefonoComprador',
        'emailComprador',
        'notasInternas',
        'idEstado',
        'created_at',
        'updated_at'
    ];
}
