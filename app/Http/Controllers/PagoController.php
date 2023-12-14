<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogTransaccion;
use App\LogTransaccionPagos;
use App\ReservaPropiedad;
use App\EstadoPago;
use App\Pago;
use App\Cargo;
use App\Descuento;
use App\Jobs\EnvioPagoArriendo;
use App\Jobs\EnviarPagoReserva;
use App\ParametroGeneral;
use Log;
class PagoController extends Controller
{
    public function condeures(Request $request)
    {
        $convenio = getenv("OTROS_PAGOS_COVENIO");
        $key = $request->p_fectr.$request->p_tid.$convenio;
        $llave = str_pad($key, 16);
        try 
        {
            $encriptacion = openssl_encrypt($llave, "AES-256-CBC", getenv("OTROS_PAGOS_KEY"), 1, getenv("OTROS_PAGOS_IV"));
        } 
        catch (\Throwable $th) 
        {
            $logPago = new LogTransaccionPagos();
            $logPago->nombreTransaccion = 'FIRMA DE OTROSPAGOS.COM NO COINCIDE EN TRANSACCION - CODIGO 65';
            $logPago->numeroTransaccion = $request->p_tid;
            $logPago->webClient = 'OtrosPagos.com - NOTPAG';
            $logPago->save();
            return response()->json(['r_retcod' => "65"], 200);
        }
        $h_firma = base64_encode($encriptacion);
        //cambiar a false
        $firmaOk = false;
        $headers = apache_request_headers();
        foreach ($headers as $header => $value) 
        {
            if($header == "H-Firma")
            {
                if($value != $h_firma)
                {
                    $logPago = new LogTransaccionPagos();
                    $logPago->nombreTransaccion = 'FIRMA NO COINCIDE EN TRANSACCION - CODIGO 65 - NOTIFICACION DE PAGO';
                    $logPago->numeroTransaccion = $idTransaccion;
                    $logPago->webClient = 'OtrosPagos.com - NOTPAG';
                    $logPago->save();
                    return response()->json(['r_retcod' => "65"], 200);
                }
                else
                {
                    $firmaOk = true;
                }
            }
        }
        $digitoVerificador = substr($request->p_idcli, -1);
        $rutSinDigito = substr($request->p_idcli, 0, -1);
        $rutUsuario = $rutSinDigito.'-'.$digitoVerificador;

        $reserva = ReservaPropiedad::where('rut', $rutUsuario)
        ->where('idEstado', 47) // cambiar
        ->first();
        $pagoReserva = false;
        $pagoMes = false;
        Log::info('Info', array('client' => $request));
        if($reserva)
        {
            if($reserva)
            {
                if($firmaOk == true)
                {
                    $pagoReserva = true;
                    $idTransaccion = (int)$request->p_tid;
                    return response()->json(['r_tid' => $idTransaccion,
                                    'r_retcod' => "00",
                                    'r_ndoc' => "0001",
                                    'r_docs' => [array(
                                        'r_doc' => "".$reserva->token."",
                                        'r_mnt' => str_pad(strval($reserva->valorReserva), 10, "0", STR_PAD_LEFT)."00",
                                        'r_mnv' => str_pad(strval($reserva->valorReserva), 10, "0", STR_PAD_LEFT)."00",
                                        'r_fve' => strftime("%Y%m%d", strtotime($reserva->fechaDePago)),
                                        'r_fem' => date('Ymd'),
                                        'r_det' => "Reserva Cliente ".$request->p_idcli." - Vencimiento ".strftime("%d%m%Y", strtotime($reserva->fechaDePago)). " - Valor: ". $reserva->valorReserva )] ], 200);
                }
                else
                {
                    $logPago = new LogTransaccionPagos();
                    $logPago->nombreTransaccion = 'FIRMA NO COINCIDE EN TRANSACCION - CODIGO 65 - CONSULTA DEUDA';
                    $logPago->numeroTransaccion = $request->p_tid;
                    $logPago->webClient = 'OtrosPagos.com - CONDEU';
                    $logPago->save();
                    return response()->json(['r_retcod' => "65"], 200);
                }
            }
            else
            {
                $logPago = new LogTransaccionPagos();
                $logPago->nombreTransaccion = 'NO EXISTE RESERVA - CONSULTA DEUDA';
                $logPago->numeroTransaccion = $request->p_tid;
                $logPago->webClient = 'OtrosPagos.com - CONDEU';
                $logPago->save();
                return response()->json(['r_retcod' => "02"], 200);
            }
        }
        if($pagoReserva == false)
        {
            $estadoDePago = EstadoPago::select('estados_pagos.*', 'users.rut', 'contratos_arriendos.idEstado')
            ->join('contratos_arriendos', 'estados_pagos.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
            ->join('users', 'users.id', '=', 'contratos_arriendos.idUsuarioArrendatario')
            ->where('users.rut', '=', $rutUsuario)
            ->where('contratos_arriendos.idEstado', '=', 61)
            ->whereIn('estados_pagos.idEstado', [ 47, 49, 50])
            ->orderBy('estados_pagos.fechaVencimiento', 'ASC')
            ->first();
    
            if($estadoDePago)
            {
                $convenio = getenv("OTROS_PAGOS_COVENIO");
                $key = $request->p_fectr.$request->p_tid.$convenio;
                $llave = str_pad($key, 16);
                try 
                {
                    $encriptacion = openssl_encrypt($llave, "AES-256-CBC", getenv("OTROS_PAGOS_KEY"), 1, getenv("OTROS_PAGOS_IV"));
                } 
                catch (\Throwable $th) 
                {
                    $logPago = new LogTransaccionPagos();
                    $logPago->nombreTransaccion = 'FIRMA DE OTROSPAGOS.COM NO COINCIDE EN TRANSACCION - CODIGO 65';
                    $logPago->numeroTransaccion = $request->p_tid;
                    $logPago->webClient = 'OtrosPagos.com - CONDEU';
                    $logPago->save();
                    return response()->json(['r_retcod' => "65"], 200);
                }
                
                $h_firma = base64_encode($encriptacion);
                //cambiar a false
                $firmaOk = false;
                $headers = apache_request_headers();
                foreach ($headers as $header => $value) 
                {
                    if($header == "H-Firma")
                    {
                        if($value != $h_firma)
                        {
                            $logPago = new LogTransaccionPagos();
                            $logPago->nombreTransaccion = 'FIRMA DE OTROSPAGOS.COM NO COINCIDE EN TRANSACCION - CODIGO 65';
                            $logPago->numeroTransaccion = $request->p_tid;
                            $logPago->webClient = 'OtrosPagos.com - CONDEU';
                            $logPago->save();
                            return response()->json(['r_retcod' => "65"], 200);
                        }
                        else
                        {
                            $firmaOk = true;
                        }
                    }
                }
                if($firmaOk == true)
                {
                    if($estadoDePago->saldo > 0)
                    {
                        $montoAPagar = $estadoDePago->saldo;
                    }
                    else
                    {
                        $montoAPagar = $estadoDePago->subtotal;
                    }
                    $pagoMes = true;
                    $idTransaccion = (int)$request->p_tid;
                    return response()->json(['r_tid' => $idTransaccion,
                                    'r_retcod' => "00",
                                    'r_ndoc' => "0001",
                                    'r_docs' => [array(
                                        'r_doc' => "".$estadoDePago->token."",
                                        'r_mnt' => str_pad(strval($montoAPagar), 10, "0", STR_PAD_LEFT)."00",
                                        'r_mnv' => str_pad(strval($montoAPagar), 10, "0", STR_PAD_LEFT)."00",
                                        'r_fve' => strftime("%Y%m%d", strtotime($estadoDePago->fechaVencimiento)),
                                        'r_fem' => date('Ymd'),
                                        'r_det' => "Cliente ".$request->p_idcli." - Vencimiento ".strftime("%d%m%Y", strtotime($estadoDePago->fechaVencimiento)). " - Valor: ". $montoAPagar )] ], 200);
                }
                else
                {
                    $logPago = new LogTransaccionPagos();
                    $logPago->nombreTransaccion = 'FIRMA NO COINCIDE EN TRANSACCION - CODIGO 65 - CONSULTA DEUDA';
                    $logPago->numeroTransaccion = $request->p_tid;
                    $logPago->webClient = 'OtrosPagos.com - CONDEU';
                    $logPago->save();
                    return response()->json(['r_retcod' => "65"], 200);
                }
            }
            else
            {
                $logPago = new LogTransaccionPagos();
                $logPago->nombreTransaccion = 'NO EXISTE PAGO - CONSULTA DEUDA';
                $logPago->numeroTransaccion = $request->p_tid;
                $logPago->webClient = 'OtrosPagos.com - CONDEU';
                $logPago->save();
                return response()->json(['r_retcod' => "03"], 200);
            }
        }
        if($pagoReserva == false && $pagoMes == false)
        {
            $logPago = new LogTransaccionPagos();
            $logPago->nombreTransaccion = 'PAGO Y RESERVA INEXISTENTE - CONSULTA DEUDA';
            $logPago->webClient = 'OtrosPagos.com - CONDEU';
            $logPago->save();
            return response()->json(['r_retcod' => "03"], 200);
        }
    }
    //notificacion de pago
    public function notpagres(Request $request)
    {
        $idTransaccion = (int)$request->p_tid;
        if($idTransaccion)
        {
            $convenio = getenv("OTROS_PAGOS_COVENIO");
            $key = $request->p_fectr.$request->p_tid.$convenio;
            $llave = str_pad($key, 16);
            try 
            {
                $encriptacion = openssl_encrypt($llave, "AES-256-CBC", getenv("OTROS_PAGOS_KEY"), 1, getenv("OTROS_PAGOS_IV"));
            } 
            catch (\Throwable $th) 
            {
                $logPago = new LogTransaccionPagos();
                $logPago->nombreTransaccion = 'FIRMA DE OTROSPAGOS.COM NO COINCIDE EN TRANSACCION - CODIGO 65';
                $logPago->numeroTransaccion = $request->p_tid;
                $logPago->webClient = 'OtrosPagos.com - NOTPAG';
                $logPago->save();
                return response()->json(['r_retcod' => "65"], 200);
            }
            $h_firma = base64_encode($encriptacion);
            //cambiar a false
            $firmaOk = false;
            $headers = apache_request_headers();
            foreach ($headers as $header => $value) 
            {
                if($header == "H-Firma")
                {
                    if($value != $h_firma)
                    {
                        $logPago = new LogTransaccionPagos();
                        $logPago->nombreTransaccion = 'FIRMA NO COINCIDE EN TRANSACCION - CODIGO 65 - NOTIFICACION DE PAGO';
                        $logPago->numeroTransaccion = $idTransaccion;
                        $logPago->webClient = 'OtrosPagos.com - NOTPAG';
                        $logPago->save();
                        return response()->json(['r_retcod' => "65"], 200);
                    }
                    else
                    {
                        $firmaOk = true;
                    }
                }
            }
            if($firmaOk == true)
            {
                //Log::info('Info', array('client' => $request));
                $reserva = ReservaPropiedad::where('token', $request->p_doc)
                ->where('idEstado', 47)
                ->first();
                $pagoReserva = false;
                $pagoMes = false;
                if($reserva)
                {
                    if($reserva)
                    {                  
                        if($firmaOk == true)
                        {
                            $reserva = ReservaPropiedad::where('token', '=', $request->p_doc)
                            ->where('idEstado', 47)
                            ->first();
                            if($reserva)
                            {
                                $reserva->idEstado = 48;
                                $reserva->save();

                                $nuevoPago = new Pago();
                                $nuevoPago->tokenReserva = $reserva->token;
                                $nuevoPago->montoPago = substr($request->p_mnt, 0, -2);
                                $nuevoPago->numeroTransaccion = $request->p_tid;
                                $nuevoPago->secuenciaTransaccion = $request->p_sectr;
                                $nuevoPago->comentarios = "Pago de reserva realizado desde OtrosPagos.com";
                                $nuevoPago->metodoPagoOtrosPagos = $request->p_idmp;
                                $nuevoPago->tipoPago = $request->p_mpti;
                                $nuevoPago->idMetodoPago = 6;
                                $nuevoPago->tokenPago = uniqid();
                                $nuevoPago->creadoPor = "Otros Pagos";
                                $nuevoPago->save();

                                $nuevoLogTransaccion = new LogTransaccion();
                                $nuevoLogTransaccion->tipoTransaccion = 'PAGO RESERVA OTROSPAGOS: '.$reserva->idReserva;
                                $nuevoLogTransaccion->webClient = "OTROSPAGOS.COM - NOTPAG";
                                $nuevoLogTransaccion->descripcionTransaccion = 'PAGO ARRIENDO OTROSPAGOS: '.$reserva->idReserva;
                                $nuevoLogTransaccion->save();
                                
                                $logPago = new LogTransaccionPagos();
                                $logPago->idPago = $nuevoPago->idPago;
                                $logPago->nombreTransaccion = 'PAGO RESERVA OTROSPAGOS DESDE OTROSPAGOS.COM - NOTIFICACION DE PAGO';
                                $logPago->numeroTransaccion = $request->p_tid;
                                $logPago->montoTransaccion = substr($request->p_mnt, 0, -2);
                                $logPago->idMetodoPago = 3;
                                $logPago->save();
                                $pagoReserva = true;
                                EnviarPagoReserva::dispatch( $nuevoPago->idPago);
                                return response()->json(['r_tid' => $idTransaccion,
                                                    'r_retcod' => "00",
                                                    'r_cau' => $request->p_doc], 200);
                            }
                            else
                            {
                                $logPago = new LogTransaccionPagos();
                                $logPago->nombreTransaccion = 'DOCUMENTO DESCONOCIDO - CODIGO 10 - NOTIFICACION DE PAGO';
                                $logPago->numeroTransaccion = $idTransaccion;
                                $logPago->webClient = 'OtrosPagos.com - NOTPAG';
                                $logPago->save();
                                return response()->json(['r_tid' => $idTransaccion,
                                    'r_retcod' => "10",
                                    'r_cau' => $request->p_doc], 200);
                            }
                        }
                        else
                        {
                            $logPago = new LogTransaccionPagos();
                            $logPago->nombreTransaccion = 'FIRMA DE OTROSPAGOS.COM NO COINCIDE EN TRANSACCION - CODIGO 65';
                            $logPago->numeroTransaccion = $idTransaccion;
                            $logPago->webClient = 'OtrosPago.com - NOTPAG';
                            $logPago->save();
                            return response()->json(['r_retcod' => "65"], 200);
                        }
                    }
                    else
                    {
                        $logPago = new LogTransaccionPagos();
                        $logPago->nombreTransaccion = 'DOCUMENTO DESCONOCIDO - CODIGO 10 - NOTIFICACION DE PAGO';
                        $logPago->numeroTransaccion = $idTransaccion;
                        $logPago->webClient = 'OtrosPagos.com - NOTPAG';
                        $logPago->save();
                        return response()->json(['r_tid' => $idTransaccion,
                                    'r_retcod' => "10",
                                    'r_cau' => $request->p_doc], 200);
                    }
                }
                $estadoDePago = EstadoPago::where('token', '=', $request->p_doc)
                ->where('idEstado', 47)
                ->first();
                if($pagoReserva == false)
                {
                    $estadoDePagoPagado = EstadoPago::where('token', '=', $request->p_doc)
                    ->where('idEstado', 48)
                    ->first();
                    if($estadoDePagoPagado)
                    {
                        $logPago = new LogTransaccionPagos();
                        $logPago->nombreTransaccion = 'PAGO YA SE ENCUENTRA REALIZADO - 01';
                        $logPago->numeroTransaccion = $idTransaccion;
                        $logPago->webClient = 'OtrosPago.com - NOTPAG';
                        $logPago->save();
                        return response()->json(['r_tid' => $idTransaccion,
                                            'r_retcod' => "01",
                                            'r_cau' => $request->p_doc], 200);
                    }
                    if($estadoDePago && $request->p_doc)
                    {
                        
                        if($firmaOk == true)
                        {
                            $estadoDePago = EstadoPago::where('token', '=', $request->p_doc)->first();
                            if($estadoDePago && $request->p_doc)
                            {
                                if($estadoDePago->saldo > 0)
                                {
                                    if(($estadoDePago->saldo - substr($request->p_mnt, 0, -2)) == 0)
                                    {
                                        $estadoDePago->idEstado = 48;
                                        $estadoDePago->saldo = 0;
                                    }
                                    else
                                    {
                                        $estadoDePago->idEstado = 47;
                                        $estadoDePago->saldo = $estadoDePago->saldo - substr($request->p_mnt, 0, -2);
                                    }
                                }
                                else
                                {
                                    if(($estadoDePago->subtotal - substr($request->p_mnt, 0, -2)) == 0)
                                    {
                                        $estadoDePago->idEstado = 48;
                                        $estadoDePago->saldo = 0;
                                    }
                                    else
                                    {
                                        $estadoDePago->idEstado = 47;
                                        $estadoDePago->saldo = $estadoDePago->subtotal - substr($request->p_mnt, 0, -2);
                                    }
                                }
                            
                                $estadoDePago->totalPagado = $estadoDePago->totalPagado + substr($request->p_mnt, 0, -2);
                                $estadoDePago->save();
                                $pagoMes = true;

                                $nuevoPago = new Pago();
                                $nuevoPago->tokenEstadoPago = $estadoDePago->token;
                                $nuevoPago->montoPago = substr($request->p_mnt, 0, -2);
                                $nuevoPago->numeroTransaccion = $request->p_tid;
                                $nuevoPago->secuenciaTransaccion = $request->p_sectr;
                                $nuevoPago->comentarios = "Pago de arriendo realizado desde OtrosPagos.com";
                                $nuevoPago->metodoPagoOtrosPagos = $request->p_idmp;
                                $nuevoPago->tipoPago = $request->p_mpti;
                                $nuevoPago->idMetodoPago = 6;
                                $nuevoPago->tokenPago = uniqid();
                                $nuevoPago->creadoPor = "Otros Pagos";
                                $nuevoPago->save();

                                $estadosDePago = EstadoPago::join('pagos', 'pagos.tokenEstadoPago', '=', 'estados_pagos.token')
                                ->where('pagos.idPago', '=', $nuevoPago->idPago)
                                ->first();

                                $nuevoLogTransaccion = new LogTransaccion();
                                $nuevoLogTransaccion->tipoTransaccion = 'PAGO ARRIENDO OTROSPAGOS: '.$estadosDePago->idEstadoPago;
                                $nuevoLogTransaccion->webclient = "OTROSPAGOS.COM";
                                $nuevoLogTransaccion->descripcionTransaccion = 'PAGO ARRIENDO OTROSPAGOS: '.$estadosDePago->idEstadoPago;
                                $nuevoLogTransaccion->save();

                                $logPago = new LogTransaccionPagos();
                                $logPago->idPago = $nuevoPago->idPago;
                                $logPago->nombreTransaccion = 'PAGO ARRIENDO OTROSPAGOS DESDE OTROSPAGOS.COM';
                                $logPago->numeroTransaccion = $request->p_tid;
                                $logPago->montoTransaccion = substr($request->p_mnt, 0, -2);
                                $logPago->webClient = 'OtrosPago.com - NOTPAG';
                                $logPago->idMetodoPago = 3;
                                $logPago->save();

                                $descuentos = Descuento::where('idEstadoPago', '=', $estadosDePago->idEstadoPago)->get();
                                $cargos = Cargo::where('idEstadoPago', '=', $estadosDePago->idEstadoPago)->get();
                                $totalDescuento = 0;
                                $totalCargo = 0;
                                if(isset($descuentos))
                                {
                                    foreach($descuentos as $descuento)
                                    {
                                        $totalDescuento = $totalDescuento + $descuento->montoDescuento;
                                    }
                                }
                                if(isset($cargos))
                                {
                                    foreach($cargos as $cargo)
                                    {
                                        $totalCargo = $totalCargo + $cargo->montoCargo;
                                    }
                                }
                                EnvioPagoArriendo::dispatch( $nuevoPago->idPago, $cargos, $descuentos, $totalCargo, $totalDescuento);
                                return response()->json(['r_tid' => $idTransaccion,
                                                    'r_retcod' => "00",
                                                    'r_cau' => $request->p_doc], 200);
                            }
                            else
                            {
                                return response()->json(['r_tid' => $idTransaccion,
                                            'r_retcod' => "10",
                                            'r_cau' => $request->p_doc], 200);
                            }
                        }
                        else
                        {
                            $logPago = new LogTransaccionPagos();
                            $logPago->nombreTransaccion = 'FIRMA DE OTROSPAGOS.COM NO COINCIDE EN TRANSACCION - CODIGO 65';
                            $logPago->numeroTransaccion = $idTransaccion;
                            $logPago->webClient = 'OtrosPago.com - NOTPAG';
                            $logPago->save();
                            return response()->json(['r_retcod' => "65"], 200);
                        }
                    }
                    else
                    {
                        $logPago = new LogTransaccionPagos();
                        $logPago->nombreTransaccion = 'DOCUMENTO SIN DEUDA - CODIGO 07 - NOTIFICACION DE PAGO';
                        $logPago->numeroTransaccion = $idTransaccion;
                        $logPago->webClient = 'OtrosPago.com - NOTPAG';
                        $logPago->save();
                        return response()->json(['r_tid' => $idTransaccion,
                                    'r_retcod' => "07",
                                    'r_cau' => $request->p_doc], 200);
                    }
                }
                if($pagoReserva == false && $pagoMes == false)
                {
                    $logPago = new LogTransaccionPagos();
                    $logPago->nombreTransaccion = 'NO EXISTE ID PARA TRANSACCION DESDE OTROSPAGOS.COM - CODIGO 12';
                    $logPago->numeroTransaccion = $idTransaccion;
                    $logPago->webClient = 'OtrosPago.com - NOTPAG';
                    $logPago->save();
                    return response()->json(['r_tid' => $idTransaccion,
                                        'r_retcod' => "12",
                                        'r_cau' => $request->p_doc], 200);
                }
            }
            else
            {
                $logPago = new LogTransaccionPagos();
                $logPago->nombreTransaccion = 'FIRMA NO COINCIDE EN TRANSACCION - CODIGO 65 - NOTIFICACION DE PAGO';
                $logPago->numeroTransaccion = $idTransaccion;
                $logPago->webClient = 'OtrosPagos.com - NOTPAG';
                $logPago->save();
                return response()->json(['r_retcod' => "65"], 200);
            }
        }
        else
        {
            $logPago = new LogTransaccionPagos();
            $logPago->nombreTransaccion = 'NO EXISTE ID PARA TRANSACCION DESDE OTROSPAGOS.COM - CODIGO 12';
            $logPago->save();
            return response()->json(['r_tid' => $idTransaccion,
                                'r_retcod' => "12",
                                'r_cau' => $request->p_doc], 200);
        }
    }
    //REVERSA DE PAGO
    public function revpag(Request $request)
    {
        Log::info('revpag', array('client' => $request));
        $idTransaccion = (int)$request->p_tid;
        $convenio = getenv("OTROS_PAGOS_COVENIO");
        $key = $request->p_fectr.$request->p_tid.$convenio;
        $llave = str_pad($key, 16);
        try 
        {
            $encriptacion = openssl_encrypt($llave, "AES-256-CBC", getenv("OTROS_PAGOS_KEY"), 1, getenv("OTROS_PAGOS_IV"));
        } 
        catch (\Throwable $th) 
        {
            $logPago = new LogTransaccionPagos();
            $logPago->nombreTransaccion = 'FIRMA DE OTROSPAGOS.COM NO COINCIDE EN TRANSACCION - CODIGO 65';
            $logPago->numeroTransaccion = $request->p_tid;
            $logPago->webClient = 'OtrosPagos.com - NOTPAG';
            $logPago->save();
            return response()->json(['r_retcod' => "65"], 200);
        }
        
        $h_firma = base64_encode($encriptacion);
        //cambiar a false
        $firmaOk = false;
        $headers = apache_request_headers();
        foreach ($headers as $header => $value) 
        {
            if($header == "H-Firma")
            {
                if($value != $h_firma)
                {
                    $logPago = new LogTransaccionPagos();
                    $logPago->nombreTransaccion = 'FIRMA NO COINCIDE EN TRANSACCION - CODIGO 65 - NOTIFICACION DE PAGO';
                    $logPago->numeroTransaccion = $idTransaccion;
                    $logPago->webClient = 'OtrosPagos.com - NOTPAG';
                    $logPago->save();
                    return response()->json(['r_retcod' => "65"], 200);
                }
                else
                {
                    $firmaOk = true;
                }
            }
        }
        $pagoArriendo = false;
        $pagoReserva = false;
        if($firmaOk == true)
        {
            $pago = Pago::where('numeroTransaccion', '=', $request->p_tid)->first();
            if($pago)
            {
                $estadoPago = EstadoPago::where('token', '=', $request->p_doc)
                ->where('idEstado', 48)
                ->first();
                if($estadoPago)
                {
                    $nuevoLogTransaccion = new LogTransaccion();
                    $nuevoLogTransaccion->tipoTransaccion = 'REVERSA PAGO OTROSPAGOS: '.$request->p_tid.' - '.$estadoPago->idEstadoPago;
                    $nuevoLogTransaccion->webclient = "OTROSPAGOS.COM";
                    $nuevoLogTransaccion->save();
                    $pagoArriendo = true;
                    $estadoPago->saldo = $estadoPago->saldo + substr($request->p_mnt, 0, -2);
                    $estadoPago->totalPagado = $estadoPago->totalPagado - substr($request->p_mnt, 0, -2);
                    if($estadoPago->totalPagado == 0 || $estadoPago->totalPagado < $estadoPago->subtotal)
                    {
                        $fechaActual = date('Y-m-d');
                        $dias = ParametroGeneral::where('parametroGeneral', '=', 'DIAS PARA PASAR PAGO A VENCIDO')->first();
                        /*if(date("Y-m-d",strtotime($estadoPago->fechaVencimiento."+ ".$dias->valorParametro." days")) < $fechaActual)
                        {
                            $estadoPago->idEstado = 50;
                        }
                        elseif($estadoPago->fechaVencimiento < $fechaActual)
                        {
                            $estadoPago->idEstado = 49;
                        }
                        else
                        {
                            $estadoPago->idEstado = 47;
                        }*/
                        $estadoPago->idEstado = 47;
                    }
                    $estadoPago->save();

                    $logPago = new LogTransaccionPagos();
                    $logPago->nombreTransaccion = 'REVERSA CORRECTA OTROSPAGOS ESTADO PAGO: '.$request->p_doc;
                    $logPago->numeroTransaccion = $request->p_tid;
                    $logPago->montoTransaccion = substr($request->p_mnt, 0, -2);
                    $logPago->webClient = 'OtrosPago.com - REVPAG';
                    $logPago->save();

                    $pago->delete();
                    return response()->json(['r_tid' => $idTransaccion,
                                            'r_retcod' => "00"], 200);
                }
                $reservaPropiedad = ReservaPropiedad::where('token', '=', $request->p_doc)
                ->where('idEstado', 48)
                ->first();
                if($reservaPropiedad)
                {
                    $reservaPropiedad->idEstado = 47;
                    $reservaPropiedad->save(); 

                    $pagoReserva = true;
                    $logPago = new LogTransaccionPagos();
                    $logPago->nombreTransaccion = 'REVERSA CORRECTA OTROSPAGOS RESERVA: '.$request->p_doc;
                    $logPago->numeroTransaccion = $request->p_tid;
                    $logPago->montoTransaccion = substr($request->p_mnt, 0, -2);
                    $logPago->webClient = 'OtrosPago.com - REVPAG - RESERVA';
                    $logPago->save();

                    $pago->delete();
                }
                if($pagoReserva == false && $pagoArriendo == false)
                {
                    $logPago = new LogTransaccionPagos();
                    $logPago->nombreTransaccion = 'REVERSA PAGO OTROSPAGOS NO SE ENCUENTRA DOCUMENTO: '.$request->p_tid;
                    $logPago->numeroTransaccion = $request->p_tid;
                    $logPago->webClient = 'OtrosPago.com - REVPAG';
                    $logPago->save();

                    $nuevoLogTransaccion = new LogTransaccion();
                    $nuevoLogTransaccion->tipoTransaccion = 'REVERSA PAGO OTROSPAGOS NO SE ENCUENTRA DOCUMENTO: '.$request->p_tid;
                    $nuevoLogTransaccion->webclient = "OTROSPAGOS.COM";
                    $nuevoLogTransaccion->save();
                    return response()->json(['r_tid' => $idTransaccion,
                                            'r_retcod' => "14"], 200);
                }
            }
            else
            {
                $logPago = new LogTransaccionPagos();
                $logPago->nombreTransaccion = 'REVERSA PAGO OTROSPAGOS NO SE ENCUENTRA ESTADO PAGO: '.$request->p_tid;
                $logPago->numeroTransaccion = $request->p_tid;
                $logPago->webClient = 'OtrosPago.com - REVPAG';
                $logPago->save();

                $nuevoLogTransaccion = new LogTransaccion();
                $nuevoLogTransaccion->tipoTransaccion = 'REVERSA PAGO OTROSPAGOS: '.$request->p_tid;
                $nuevoLogTransaccion->webclient = "OTROSPAGOS.COM";
                $nuevoLogTransaccion->save();
                return response()->json(['r_tid' => $idTransaccion,
                                        'r_retcod' => "14"], 200);
            }
        }
        else
        {
            $logPago = new LogTransaccionPagos();
            $logPago->nombreTransaccion = 'FIRMA DE OTROSPAGOS.COM NO COINCIDE EN TRANSACCION - CODIGO 65';
            $logPago->numeroTransaccion = $idTransaccion;
            $logPago->webClient = 'OtrosPago.com - NOTPAG';
            $logPago->save();
            return response()->json(['r_retcod' => "65"], 200);
        }
    }
    public function pagoArriendoExitoso(Request $request)
    {
        $estadosDePago = EstadoPago::select('estados_pagos.*', 'pagos.montoPago', 'pagos.numeroTransaccion', 'pagos.tokenPago', 'pagos.secuenciaTransaccion')
        ->join('pagos', 'pagos.tokenEstadoPago', '=', 'estados_pagos.token')
        ->where('estados_pagos.token', '=', $request->tokenEstadoPago)
        ->first();
        if($estadosDePago)
        {
            if($estadosDePago->saldo == 0)
            {
                return response()->json(['estado' => 1,
                                    'pago' => $estadosDePago], 200);
            }
        }
        else
        {
            return response()->json(['estado' => 0,
            'pago' => ''], 200);
        }
    }
    public function pagoReservaExitosa(Request $request)
    {
        $reserva = ReservaPropiedad::select('reservas_propiedades.*', 'pagos.montoPago', 'pagos.numeroTransaccion', 'pagos.tokenPago', 'pagos.secuenciaTransaccion')
        ->join('pagos', 'pagos.tokenReserva', '=', 'reservas_propiedades.token')
        ->where('reservas_propiedades.token', '=', $request->tokenEstadoPago)
        ->first();
        if($reserva)
        {
            if($reserva->idEstado == 48)
            {
                return response()->json(['estado' => 1,
                                    'pago' => $reserva], 200);
            }
        }
        else
        {
            return response()->json(['estado' => 0,
            'pago' => ''], 200);
        }
    }
    public function pruebaCorreo(Request $request)
    {
        $nuevoPago = Pago::where('idPago', 31)->first();
        $estadosDePago = EstadoPago::where('token', $nuevoPago->tokenEstadoPago)->first(); 
        $descuentos = Descuento::where('idEstadoPago', '=', $estadosDePago->idEstadoPago)->get();
        $cargos = Cargo::where('idEstadoPago', '=', $estadosDePago->idEstadoPago)->get();
        $totalDescuento = 0;
        $totalCargo = 0;
        if(isset($descuentos))
        {
            foreach($descuentos as $descuento)
            {
                $totalDescuento = $totalDescuento + $descuento->montoDescuento;
            }
        }
        if(isset($cargos))
        {
            foreach($cargos as $cargo)
            {
                $totalCargo = $totalCargo + $cargo->montoCargo;
            }
        }
        EnvioPagoArriendo::dispatch( $nuevoPago->idPago, $cargos, $descuentos, $totalCargo, $totalDescuento);
        /*$nuevoPago = Pago::where('idPago', 47)->first();
        EnviarPagoReserva::dispatch( $nuevoPago->idPago);*/
    }
}
