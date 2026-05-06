<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $fillable = [
        'nombre',
        'descripcion'
    ];
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'rol_usuario',
            'id_rol',
            'id_usuario'
        );
    }
}
