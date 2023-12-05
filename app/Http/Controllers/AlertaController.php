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
        $diasAlerta1 = ParametroGeneral::where('parametroGeneral', '=', "ALERTA YA SE ENCUENTRA TU PAGO")->first();

        $estadosPagos = EstadoPago::select('estados_pagos.*', 'users.email', 'users.id as idUsuario', 'users.name', 'users.apellido')
        ->join('contratos_arriendos', 'contratos_arriendos.idContratoArriendo', '=', 'estados_pagos.idContrato')
        ->join('users', 'users.id', '=', 'contratos_arriendos.idUsuarioArrendatario')
        ->whereIn('estados_pagos.idEstado', [47])
        ->get();
        if(!$estadosPagos->isEmpty())
        {
            foreach ($estadosPagos as $estadoPago) 
            { 
                if($diasAlerta1->valorParametro != -1)
                {
                    //return date("Y-m-d",strtotime($estadoPago->fechaVencimiento."- ".$diasAlerta1->valorParametro." days"));
                    if(date("Y-m-d",strtotime($estadoPago->fechaVencimiento."- ".$diasAlerta1->valorParametro." days")) == $fechaActual)
                    {
                        //return $estadoPago;
                        YaSeEncuentraDisponibleTuPagoJob::dispatch($estadoPago);
                        $nuevoLogCorreo = new LogCorreoEnviado();
                        $nuevoLogCorreo->nombre_tipo_correo = 'RECORDATORIO PAGO DE ARRIENDO '. $diasAlerta1->valorParametro .' DIAS ANTES';
                        $nuevoLogCorreo->usuario = 'CRON AUTOMATIZADO';
                        $nuevoLogCorreo->save();
                    }
                }
            }
        }
    }
    public function pruebaMail()
    {
        $fechaActual = date('Y-m-d');
        $diasAlerta1 = ParametroGeneral::where('parametroGeneral', '=', "ALERTA YA SE ENCUENTRA TU PAGO")->first();

        $estadosPagos = EstadoPago::select('estados_pagos.*', 'users.email', 'users.id as idUsuario', 'users.name', 'users.apellido')
        ->join('contratos_arriendos', 'contratos_arriendos.idContratoArriendo', '=', 'estados_pagos.idContrato')
        ->join('users', 'users.id', '=', 'contratos_arriendos.idUsuarioArrendatario')
        ->whereIn('estados_pagos.idEstado', [47])
        ->get();
        if(!$estadosPagos->isEmpty())
        {
            foreach ($estadosPagos as $estadoPago) 
            { 
                if($diasAlerta1->valorParametro != -1)
                {
                    //var_dump(date("Y-m-d",strtotime($estadoPago->fechaVencimiento."- ".$diasAlerta1->valorParametro." days")));
                    //return date("Y-m-d",strtotime($estadoPago->fechaVencimiento."- ".$diasAlerta1->valorParametro." days"));
                    if(date("Y-m-d",strtotime($estadoPago->fechaVencimiento."- ".$diasAlerta1->valorParametro." days")) == $fechaActual)
                    {
                        var_dump(date("Y-m-d",strtotime($estadoPago->fechaVencimiento."- ".$diasAlerta1->valorParametro." days")));
                        //return $estadoPago;
                        /*YaSeEncuentraDisponibleTuPagoJob::dispatch($estadoPago);*/
                        $nuevoLogCorreo = new LogCorreoEnviado();
                        $nuevoLogCorreo->nombre_tipo_correo = 'RECORDATORIO PAGO DE ARRIENDO '. $diasAlerta1->valorParametro .' DIAS ANTES';
                        $nuevoLogCorreo->usuario = 'CRON AUTOMATIZADO';
                        $nuevoLogCorreo->save();
                    }
                }
            }
        }
    }
}
