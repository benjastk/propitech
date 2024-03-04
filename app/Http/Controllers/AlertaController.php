<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SMS;
use App\EstadoPago;
use App\LogCorreoEnviado;
use App\ParametroGeneral;
use App\Jobs\YaSeEncuentraDisponibleTuPagoJob;
use App\Jobs\UltimoDiaParaPagar;
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
    public function ultimoDiaParaPagar()
    {
        $fechaActual = date('Y-m-d');
        $anioActual = date('Y');
        $mesActual = date('m');

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
                if(date("Y-m-d",strtotime($estadoPago->fechaVencimiento)) == $fechaActual)
                {
                    UltimoDiaParaPagar::dispatch($estadoPago);
                    $nuevoLogCorreo = new LogCorreoEnviado();
                    $nuevoLogCorreo->nombre_tipo_correo = 'RECORDATORIO PAGO DE ARRIENDO ULTIMO DIA';
                    $nuevoLogCorreo->usuario = 'CRON AUTOMATIZADO';
                    $nuevoLogCorreo->save();
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
                /*YaSeEncuentraDisponibleTuPagoJob::dispatch($estadoPago);
                $nuevoLogCorreo = new LogCorreoEnviado();
                $nuevoLogCorreo->nombre_tipo_correo = 'RECORDATORIO PAGO DE ARRIENDO MANUAL';
                $nuevoLogCorreo->usuario = 'URL MANUAL';
                $nuevoLogCorreo->save();*/
                dd();
            }
        }
        return "listo";
    }
    public function mailPorCorreo(Request $request)
    {
        $fechaActual = date('Y-m-d');
        $anioActual = date('Y');
        $mesActual = date('m');
        $estadosPagos = EstadoPago::select('estados_pagos.*', 'users.email', 'users.id as idUsuario', 'users.name', 'users.apellido')
        ->join('contratos_arriendos', 'contratos_arriendos.idContratoArriendo', '=', 'estados_pagos.idContrato')
        ->join('users', 'users.id', '=', 'contratos_arriendos.idUsuarioArrendatario')
        ->whereIn('estados_pagos.idEstado', [47])
        ->where('contratos_arriendos.idEstado', 61)
        ->where('users.email', '=', $request->mail)
        ->whereMonth('estados_pagos.fechaVencimiento', '=', $mesActual)
        ->whereYear('estados_pagos.fechaVencimiento', '=', $anioActual)
        ->first();
        if($estadosPagos)
        {
            UltimoDiaParaPagar::dispatch($estadosPagos);
            $nuevoLogCorreo = new LogCorreoEnviado();
            $nuevoLogCorreo->nombre_tipo_correo = 'RECORDATORIO PAGO DE ARRIENDO ULTIMO DIA';
            $nuevoLogCorreo->usuario = 'CRON AUTOMATIZADO';
            $nuevoLogCorreo->save();
        }
        return "listo";
    }
    public function recordarPagoSMS()
    {
        try{
            $fechaActual = date('Y-m-d');
            $anioActual = date('Y');
            $mesActual = date('m');
            $diasAlerta1 = ParametroGeneral::where('parametroGeneral', '=', "ALERTA YA SE ENCUENTRA TU PAGO")->first();

            $estadosPagos = EstadoPago::select('estados_pagos.*', 'users.email', 'users.id as idUsuario', 'users.name', 'users.apellido', 'users.telefono')
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
                    $enviar = SMS::sendSMS();
                    $enviar['cliente']->messages->create( $estadoPago->telefono,
                        ['from' => $enviar['numero'], 'body' => 'Estimado'. $estadoPago->name. ' '. $estadoPago->apellido.', ya se encuentra disponible el pago de tu arriendo del mes de Marzo.
                        Puede pagar en www.propitech.cl/pago-online. Equipo Propitech'] );
                }
            }
            return "listo";
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
