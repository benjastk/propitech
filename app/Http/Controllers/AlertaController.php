<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EstadoPago;
use App\LogCorreoEnviado;
use App\ParametroGeneral;
use App\Jobs\YaSeEncuentraDisponibleTuPagoJob;
class AlertaController extends Controller
{
    public function recordarPagoArrendatariosMensual()
    {
        $fechaActual = date('Y-m-d');
        $anioActual = date('Y');
        $mesActual = date('m');
        $diasAlerta1 = ParametroGeneral::where('parametroGeneral', '=', "ALERTA YA SE ENCUENTRA TU PAGO")->first();

        $estadosPagos = EstadoPago::select('estados_pagos.*', 'users.email', 'users.id as idUsuario', 'users.name', 'users.apellido')
        ->join('contratos_arriendos', 'contratos_arriendos.idContratoArriendo', '=', 'estados_pagos.idContrato')
        ->join('users', 'users.id', '=', 'contratos_arriendos.idUsuarioArrendatario')
        ->whereIn('estados_pagos.idEstado', [47])
        ->where('contratos_arriendos.idEstado', 61)
        ->whereMonth('estados_pagos.fechaVencimiento', '=', $mesActual)
        ->whereYear('estados_pagos.fechaVencimiento', '=', $anioActual)
        ->get();
        if(!$estadosPagos->isEmpty())
        {
            foreach ($estadosPagos as $estadoPago) 
            { 
                if($diasAlerta1->valorParametro != -1)
                {
                    if(date("Y-m-d",strtotime($estadoPago->fechaVencimiento."- ".$diasAlerta1->valorParametro." days")) == $fechaActual)
                    {
                        YaSeEncuentraDisponibleTuPagoJob::dispatch($estadoPago);
                        $nuevoLogCorreo = new LogCorreoEnviado();
                        $nuevoLogCorreo->nombre_tipo_correo = 'RECORDATORIO PAGO DE ARRIENDO '. $diasAlerta1->valorParametro .' DIAS ANTES';
                        $nuevoLogCorreo->usuario = 'CRON AUTOMATIZADO';
                        $nuevoLogCorreo->save();
                    }
                }
            }
        }
        return "listo";
    }
    public function pruebaMail()
    {
        $fechaActual = date('Y-m-d');
        $anioActual = date('Y');
        $mesActual = date('m');
        $diasAlerta1 = ParametroGeneral::where('parametroGeneral', '=', "ALERTA YA SE ENCUENTRA TU PAGO")->first();

        $estadosPagos = EstadoPago::select('estados_pagos.*', 'users.email', 'users.id as idUsuario', 'users.name', 'users.apellido')
        ->join('contratos_arriendos', 'contratos_arriendos.idContratoArriendo', '=', 'estados_pagos.idContrato')
        ->join('users', 'users.id', '=', 'contratos_arriendos.idUsuarioArrendatario')
        ->whereIn('estados_pagos.idEstado', [47])
        ->where('contratos_arriendos.idEstado', 61)
        ->whereMonth('estados_pagos.fechaVencimiento', '=', $mesActual)
        ->whereYear('estados_pagos.fechaVencimiento', '=', $anioActual)
        ->get();
        if(!$estadosPagos->isEmpty())
        {
            foreach ($estadosPagos as $estadoPago) 
            { 
                YaSeEncuentraDisponibleTuPagoJob::dispatch($estadoPago);
                $nuevoLogCorreo = new LogCorreoEnviado();
                $nuevoLogCorreo->nombre_tipo_correo = 'RECORDATORIO PAGO DE ARRIENDO MANUAL';
                $nuevoLogCorreo->usuario = 'URL MANUAL';
                $nuevoLogCorreo->save();
            }
        }
        return "listo";
    }
}
