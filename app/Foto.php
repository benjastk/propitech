<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table = 'fotos';
    protected $primaryKey = 'idFoto';
    protected $fillable = [
    	'idPropiedad',
    	'nombreArchivo',
        'marcaDeAgua',
        'created_at',
        'updated_at'
    ];
}
