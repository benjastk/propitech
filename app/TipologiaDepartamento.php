<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipologiaDepartamento extends Model
{
    protected $table ='tipologias_departamentos';
    protected $primaryKey = 'idTipologiaDepartamento';
    protected $fillable = [
        'idTipologia',
        'idProyecto',
        'created_at',
        'updated_at'
    ];
}
