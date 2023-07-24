<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email', 
        'password',
        'telefono',
        'rut',
        'rutDos',
        'numeroSerie',
        'apellido',
        'linkedinUrl',
        'facebookUrl',
        'twitterUrl',
        'instagramUrl',
        'edad',
        'idPais',
        'idRegion',
        'idProvincia',
        'idComuna',
        'direccion',
        'numero',
        'idTipoUsuario',
        'publicarExpertoEnWeb',
        'idGenero',
        'nacionalidad',
        'estadoCivil',
        'profesion',
        'webClient',
        'aceptoTerminos',
        'tokenParaActivacion',
        'cuentaActivada',
        'fechaActivada',
        'avatarImg',
        'vendeID',
        'enviarNotificacionSMS',
        'idTipoUsuarioComercial',
        'idRentaMensual',
        'idComoNosConocio',
        'eliminado',
        'idSubTipoUsuario',
        'observacionesGenerales',
        'esInmobiliaria',
        'creadoPor',
        'idTipoRut',
        'tokenCorto'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function rol()
    {
        return $this->hasOne('App\UserRol', 'id_usuario');
    }
}
