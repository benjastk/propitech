<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Noticia extends Model
{
    protected $table = 'noticias';
    protected $primaryKey = 'idNoticia';
    protected $fillable = [
        'codigoEmpresa',
        'fechaPublicacion',
        'titulo',
        'textoResumen',
        'texto',
        'imagenNoticia',
        'idUsuario',
        'noticiaEnviada',
        'urlNoticia',
        'created_at',
        'updated_at',
        'deleteOf'
    ];
}
