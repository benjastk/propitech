<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipologia extends Model
{
    protected $table ='tipologias';
    protected $primaryKey = 'idTipologia';
    protected $fillable = [
        'descripcionTipologia',
        'mContruidos',
        'mTotales',
        'fotoTipologia',
        'idProyecto',
        'dormitorios',
        'banos',
        'created_at',
        'updated_at'
    ];
}
