<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaracteristicaPlanAsignada extends Model
{
    protected $table = 'caracteristicas_planes_asignadas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idPlan',
        'idCaracteristicaPlan',
        'created_at',
        'updated_at'
    ];
}
