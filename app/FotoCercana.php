<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotoCercana extends Model
{
    protected $table = 'fotos_cercanas';
    protected $primaryKey = 'idFotoCercana';
    protected $fillable = [
    	'idProyecto',
    	'nombreArchivo',
        'created_at',
        'updated_at'
    ];
}
