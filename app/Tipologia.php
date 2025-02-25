<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipologia extends Model
{
    protected $table ='tipologias';
    protected $primaryKey = 'idTipologia';
    protected $fillable = [
        'descripcionTipologia', //units->description
        'mContruidos', //units->m2
        'mTotales', //m2 + m2_outdoor
        'fotoTipologia',// if plan
        'idProyecto',//
        'dormitorios',//bedrooms
        'banos',//bathrooms
        'created_at',
        'updated_at'
    ];
}
