<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MantencionPropiedad extends Model
{
    protected $table = 'mantenciones_propiedades';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_propiedad',
        'direccion',
        'numero',
        'block',
        'mantencion_termo',
        'mantencion_encimera',
        'mantencion_calefont',
        'user_id',
        'tipo_mantencion',
        'created_at',
        'updated_at'
    ];
}
