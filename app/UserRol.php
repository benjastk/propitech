<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRol extends Model
{
    protected $table = 'rol_usuario';
    protected $primaryKey = 'id_rol_usuario';
    protected $fillable = [
        'id_rol_usuario',
        'id_usuario',
        'id_rol'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
