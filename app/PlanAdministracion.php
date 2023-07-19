<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanAdministracion extends Model
{
    protected $table = 'planes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'activo',
        'nombre',
        'comisionCorretaje',
        'ivaCorretaje',
        'comisionAdministracion',
        'ivaAdministracion',
        'destacado',
        'created_at',
        'updated_at'
    ];
}
