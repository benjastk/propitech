<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotoProyecto extends Model
{
    protected $table = 'fotos_proyectos';
    protected $primaryKey = 'id';
    protected $fillable = [
    	'idProyecto',
    	'nombreArchivo',
        'created_at',
        'updated_at'
    ];
}
