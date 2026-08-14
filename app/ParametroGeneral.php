<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ParametroGeneral extends Model
{
    protected $table = 'parametros_generales';
    protected $primaryKey = 'idParametroGeneral';
    protected $fillable = [
        'parametroGeneral',
        'valorParametro',
        'textoValorParametro',
        'notas',
        'created_at',
        'updated_at'
    ];

    /**
     * Devuelve un parametro general por nombre desde una cache compartida
     * (una sola query trae todos, en vez de una query por cada parametro).
     */
    public static function obtener($nombre)
    {
        return Cache::remember('parametros_generales', now()->addMinutes(30), function () {
            return self::all()->keyBy('parametroGeneral');
        })->get($nombre);
    }
}
