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
        setlocale(LC_TIME, 'es_ES', 'Spanish_Spain', 'Spanish');
        $mesPalabras = strftime("%B");
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
                if($diasAlerta1->valorParametro != -1)
                {
                    if(date("Y-m-d",strtotime($estadoPago->fechaVencimiento."- ".$diasAlerta1->valorParametro." days")) == $fechaActual)
                    {
                        $enviar = SMS::sendSMS();
                        $var = $enviar['cliente']->messages->create( 'whatsapp:+56'. $estadoPago->telefono,
                            ['from' => 'whatsapp:'.$enviar['numero'], 
                            'messagingServiceSid ' => 'MGd211ce449e9d2c3193f109fd199e1a3a', 
                            'body' => "¡Hola ".$estadoPago->name."👋!

                            Ya se encuentra disponible el pago de tu arriendo del mes de ".$mesPalabras." de ".$anioActual.".
                            Para realizar el pago sólo debes hacer clic en el siguiente enlace👇:
                            https://www.propitech.cl/pago-online
                            
                            1.- Digita tu rut sin puntos y con guion.
                            2.- Aparecerá tu deuda actual
                            3.- Se abrirá una nueva pestaña de nuestro proveedor otrospagos.com

                            * Al momento de realizar tu pago exitoso, recibirás tu comprobante automáticamente desde la casilla contacto@propitech.cl (recuerda revisar tu Spam)
                            * Evita fraudes pagando directamente en nuestro link de pago y transferencias directas a nuestra empresa sin intermediarios

                            En caso de dudas o consultas puedes contactarnos directamente con tu ejecutivo o por el botón que se encuentra en nuestro sitio web.

                            PROPITECH By Cirobu
                            Hacemos tu sueño realidad. "] 
                        );
                        $nuevoLogCorreo = new LogCorreoEnviado();
                        $nuevoLogCorreo->nombre_tipo_correo = 'RECORDATORIO PAGO DE ARRIENDO DIAS ANTES POR WHATSAPP';
                        $nuevoLogCorreo->usuario = 'CRON AUTOMATIZADO - TELEFONO: '. $estadoPago->telefono;
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
        setlocale(LC_TIME, 'es_ES', 'Spanish_Spain', 'Spanish');
        $mesPalabras = strftime("%B");

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
                if(date("Y-m-d",strtotime($estadoPago->fechaVencimiento)) == $fechaActual)
                {
                    //UltimoDiaParaPagar::dispatch($estadoPago);
                    $enviar = SMS::sendSMS();
                    $var = $enviar['cliente']->messages->create( 'whatsapp:+56'. $estadoPago->telefono,
                        ['from' => 'whatsapp:'.$enviar['numero'], 
                        'messagingServiceSid ' => 'MGd211ce449e9d2c3193f109fd199e1a3a', 
                        'body' => "¡Hola ".$estadoPago->name. "👋!
                        
                        Recuerda que el pago de tu arriendo del mes de ".$mesPalabras." de ".$anioActual." vence hoy. Evita generar intereses
                        Para realizar el pago sólo debes hacer clic en el siguiente enlace👇:
                        https://www.propitech.cl/pago-online
                        
                        1.- Digita tu rut sin puntos y con guion.
                        2.- Aparecerá tu deuda actual
                        3.- Se abrirá una nueva pestaña de nuestro proveedor otrospagos.com

                        * Al momento de realizar tu pago exitoso, recibirás tu comprobante automáticamente desde la casilla contacto@propitech.cl (recuerda revisar tu Spam)
                        * Evita fraudes pagando directamente en nuestro link de pago y transferencias directas a nuestra empresa sin intermediarios

                        En caso de dudas o consultas puedes contactarnos directamente con tu ejecutivo o por el botón que se encuentra en nuestro sitio web.

                        PROPITECH By Cirobu
                        Hacemos tu sueño realidad. "] 
                    );
                    $nuevoLogCorreo = new LogCorreoEnviado();
                    $nuevoLogCorreo->nombre_tipo_correo = 'ULTIMO DIA RECORDATORIO PAGO DE ARRIENDO POR WHATSAPP';
                    $nuevoLogCorreo->usuario = 'CRON AUTOMATIZADO - TELEFONO: '. $estadoPago->telefono;
                    $nuevoLogCorreo->save();
                }
            }
        }
        return "listo";
    }
    public function pruebaMail()
    {
        /*$fechaActual = date('Y-m-d');
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
                $nuevoLogCorreo->save();
                dd();
            }
        }*/
        $enviar = SMS::sendSMS();
        $var = $enviar['cliente']->messages->create( 'whatsapp:+56989583599',
            ['from' => 'whatsapp:'.$enviar['numero'], 
            'messagingServiceSid ' => 'MGd211ce449e9d2c3193f109fd199e1a3a', 
            'body' => "¡Hola Benjamin👋!

            Ya se encuentra disponible el pago de tu arriendo del mes de Agosto de 2024.
            Para realizar el pago sólo debes hacer clic en el siguiente enlace👇:
            https://www.propitech.cl/pago-online
            
            1.- Digita tu rut sin puntos y con guion.
            2.- Aparecerá tu deuda actual
            3.- Se abrirá una nueva pestaña de nuestro proveedor otrospagos.com

            * Al momento de realizar tu pago exitoso, recibirás tu comprobante automáticamente desde la casilla contacto@propitech.cl (recuerda revisar tu Spam)
            * Evita fraudes pagando directamente en nuestro link de pago y transferencias directas a nuestra empresa sin intermediarios

            En caso de dudas o consultas puedes contactarnos directamente con tu ejecutivo o por el botón que se encuentra en nuestro sitio web.

            PROPITECH By Cirobu
            Hacemos tu sueño realidad. "] 
        );
        $nuevoLogCorreo = new LogCorreoEnviado();
        $nuevoLogCorreo->nombre_tipo_correo = 'ULTIMO DIA RECORDATORIO PAGO DE ARRIENDO POR WHATSAPP';
        $nuevoLogCorreo->usuario = 'CRON AUTOMATIZADO - TELEFONO: 989583599';
        $nuevoLogCorreo->save();
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
                    $enviar['cliente']->messages->create( '+56'.$estadoPago->telefono,
                        ['from' => $enviar['numero'], 'body' => 'Estimado/a '. $estadoPago->name. ' '. $estadoPago->apellido.', ya se encuentra disponible el pago de tu arriendo del mes de Marzo.
                        Puede pagar en www.propitech.cl/pago-online. Equipo Propitech'] );
                }
            }
            return "listo";
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function recordarPagoWhatsapp(Request $request)
    {
        try{
            setlocale(LC_TIME, 'es_ES', 'Spanish_Spain', 'Spanish');
            $fechaActual = date('Y-m-d');
            $anioActual = date('Y');
            $mesActual = date('m');
            $mesPalabras = strftime("%B");

            $estadosPagos = EstadoPago::select('estados_pagos.*', 'users.email', 'users.id as idUsuario', 'users.name', 'users.apellido', 'users.telefono')
            ->join('contratos_arriendos', 'contratos_arriendos.idContratoArriendo', '=', 'estados_pagos.idContrato')
            ->join('users', 'users.id', '=', 'contratos_arriendos.idUsuarioArrendatario')
            ->whereIn('estados_pagos.idEstado', [47, 49, 50])
            ->where('contratos_arriendos.idEstado', 61)
            ->whereMonth('estados_pagos.fechaVencimiento', '=', $mesActual)
            ->whereYear('estados_pagos.fechaVencimiento', '=', $anioActual)
            ->get();
            if(!$estadosPagos->isEmpty())
            {
                foreach ($estadosPagos as $estadoPago) 
                { 
                    if($request->usuarios)
                    {
                        foreach ($request->usuarios as $usuarioo) 
                        {
                            if($estadoPago->idUsuario == $usuarioo)
                            {
                                $enviar = SMS::sendSMS();
                                $var = $enviar['cliente']->messages->create( 'whatsapp:+56'. $estadoPago->telefono,
                                    ['from' => 'whatsapp:'.$enviar['numero'], 
                                    'messagingServiceSid ' => 'MGd211ce449e9d2c3193f109fd199e1a3a', 
                                    'body' => "¡Estimado ".$estadoPago->name. "👋!

                                    Recuerda que el pago de tu arriendo del mes de ".$mesPalabras." de ".$anioActual." ya venció. Evita generar más intereses.
                                    Para realizar el pago sólo debes hacer clic en el siguiente enlace👇:
                                    https://www.propitech.cl/pago-online
                                    
                                    1.- Digita tu rut sin puntos y con guion.
                                    2.- Aparecerá tu deuda actual
                                    3.- Se abrirá una nueva pestaña de nuestro proveedor otrospagos.com

                                    * Al momento de realizar tu pago exitoso, recibirás tu comprobante automáticamente desde la casilla contacto@propitech.cl (recuerda revisar tu Spam)
                                    * Evita fraudes pagando directamente en nuestro link de pago y transferencias directas a nuestra empresa sin intermediarios

                                    En caso de dudas o consultas puedes contactarnos directamente con tu ejecutivo o por el botón que se encuentra en nuestro 
                                    RECUERDA que este mensaje es automático y no se reciben respuestas a este chat.

                                    PROPITECH By Cirobu
                                    Hacemos tu sueño realidad."] 
                                );
                            }
                        }
                    }
                }
            }
            toastr()->success('Mensajes enviados exitosamente');
            return redirect('/parametros');
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
