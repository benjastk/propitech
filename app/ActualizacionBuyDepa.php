<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActualizacionBuyDepa extends Model
{
    protected $table = 'actualizaciones_buyDepa';
    protected $fillable = [
        'id',
        'creadas',
        'actualizadas',
        'eliminadas',
        'created_at',
        'updated_at'
    ];
}
