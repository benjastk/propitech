<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Mail\YaSeEncuentraDisponibleTuPago;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Jobs\EnvioPagoArriendo;
use Illuminate\Http\Request;
use App\ParametroGeneral;
use App\ContratoArriendo;
use App\LogTransaccion;
use App\DocumentoPago;
use App\EstadoPago;
use App\MetodoPago;
use App\Propiedad;
use Carbon\Carbon;
use App\Descuento;
use App\Estado;
use App\Cargo;
use App\Pago;
use App\User;
use Session;
use Auth;
use DB;
class EstadoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $ultimoEstadoPago = EstadoPago::where('idContrato', $request->idContrato)
            ->orderBy('idEstadoPago', 'desc')
            ->first();
            $estadoPago = new EstadoPago();
            $estadoPago->fill($request->all());
            $estadoPago->subtotal = $request->arriendoMensual + $request->garantia + $request->comision;
            $estadoPago->editado = 0;
            $estadoPago->idContrato = $request->idContrato;
            $estadoPago->token = uniqid();
            $estadoPago->numeroCuota = $ultimoEstadoPago->numeroCuota + 1;
            $estadoPago->idEstado = 47;
            $estadoPago->garantiaDos = 0;
            $estadoPago->totalPagado = 0;
            $estadoPago->creadoPor = Auth::user()->id;
            $estadoPago->save();
            
            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Creacion de Estado de Pago';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Creacion de Estado de Pago: '. $estadoPago->idEstadoPago. ' - Arriendo: '.
            $estadoPago->arriendoMensual.' - Garantia: '. $estadoPago->garantia.' - Comision: '. $estadoPago->comision.'';
            $logTransaccion->save();

            DB::commit();
            toastr()->success('Estado de pago actualizado exitosamente');
            return redirect('/estados-pagos/mostrar/'.$estadoPago->idContrato );
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $estadosPagos = EstadoPago::select('estados_pagos.*', 'estados.nombreEstado', 'estados.idEstado', 'contratos_arriendos.nombreArrendatario',
        'contratos_arriendos.rutArrendatario', 'contratos_arriendos.apellidoArrendatario')
        ->join('estados', 'estados.idEstado', '=', 'estados_pagos.idEstado')
        ->join('contratos_arriendos', 'contratos_arriendos.idContratoArriendo', '=', 'estados_pagos.idContrato')
        ->where('estados_pagos.idContrato', '=', $id)
        ->orderBy('fechaVencimiento', 'asc')
        ->get();
        $descuentos = Descuento::where('idEstadoPago', $id)->get();

        if($estadosPagos)
        {
            foreach ($estadosPagos as $estadoPago) 
            {
                $cargos = Cargo::where('idEstadoPago', $estadoPago->idEstadoPago)->get();
                if($cargos)
                {
                    $estadoPago->cargos = $cargos;
                }
                $descuentos = Descuento::where('idEstadoPago', $estadoPago->idEstadoPago)->get();
                if($descuentos)
                {
                    $estadoPago->descuentos = $descuentos;
                }
            }
        }
        $contrato = ContratoArriendo::where('idContratoArriendo', $id)->first();
        $propiedad = Propiedad::where('id', $contrato->idPropiedad)->first();
        $metodosPagos = MetodoPago::get();
        return view ('back-office.estadoPago.indexForContratos', compact('user', 'estadosPagos', 'contrato', 'propiedad', 'metodosPagos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $estadoPago = EstadoPago::select('estados_pagos.*', 'estados.nombreEstado', 'estados.idEstado', 'contratos_arriendos.nombreArrendatario',
        'contratos_arriendos.rutArrendatario', 'contratos_arriendos.apellidoArrendatario')
        ->join('estados', 'estados.idEstado', '=', 'estados_pagos.idEstado')
        ->join('contratos_arriendos', 'contratos_arriendos.idContratoArriendo', '=', 'estados_pagos.idContrato')
        ->where('estados_pagos.idEstadoPago', '=', $id)
        ->first();
        $estados = Estado::where('idTipoEstado', 10)->get();
        $contrato = ContratoArriendo::where('idContratoArriendo', $estadoPago->idContrato)->first();
        $propiedad = Propiedad::where('id', $contrato->idPropiedad)->first();
        $descuentos = Descuento::where('idEstadoPago', $id)->get();
        $cargos = Cargo::where('idEstadoPago', $id)->get();
        return view ('back-office.estadoPago.edit', compact('user', 'estadoPago', 'contrato', 'propiedad', 'estados', 'descuentos', 'cargos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $estadoPago = EstadoPago::where('idEstadoPago', '=', $id)->firstOrFail();
            $arriendoMensualAnterior = $estadoPago->arriendoMensual;
            $garantiaAnterior = $estadoPago->garantia;
            $comisionAnterior = $estadoPago->comision;
            $estadoPago->fill($request->all());
            $estadoPago->subtotal = $request->arriendoMensual + $request->garantia + $request->comision;
            $estadoPago->editado = 1;
            $estadoPago->save();
            
            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Actualizacion de Estado de Pago';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Actualizacion de Estado de Pago: '. $estadoPago->idEstadoPago. ' - Arriendo Anterior: '.
            $arriendoMensualAnterior.' - Garantia anterior: '. $garantiaAnterior.' - Comision anterior: '. $comisionAnterior.' - Arriendo Nuevo: '. 
            $request->arriendoMensual.' - Garantia Nueva: '. $request->garantia.' - Comision Nueva: '. $request->comision;
            $logTransaccion->save();

            DB::commit();
            toastr()->success('Estado de pago actualizado exitosamente');
            return redirect('/estados-pagos/mostrar/'.$estadoPago->idContrato );
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            toastr()->warning('No se puede eliminar un estado de pago, favor contacte al administrador', 'Verificar operación');
            return redirect('/estados-pagos/mostrar/'.$request->id);
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        }
    }

    public function createCargoDescuento(Request $request)
    {
        try{
            $user = Auth::user();
            DB::beginTransaction();
            if($request->tipo == 1)
            {
                $cargo = new Cargo();
                $cargo->idEstadoPago = $request->idEstadoPago;
                $cargo->nombreCargo = $request->nombre;
                $cargo->descripcionCargo = $request->descripcion;
                $cargo->montoCargo = $request->monto;
                $cargo->correspondeA = $request->correspondeA;
                $cargo->cargoValidado = 1;
                $cargo->creadoPor = "1";
                $cargo->save();
                DB::commit();

                $estadoPago = EstadoPago::where('idEstadoPago', $request->idEstadoPago)->first();
                $estadoPago->subtotal = $estadoPago->subtotal + $request->monto;
                if($estadoPago->saldo > 0)
                {
                    $estadoPago->saldo = $estadoPago->saldo + $request->monto;
                }
                $estadoPago->save();

                $logTransaccion = new LogTransaccion();
                $logTransaccion->tipoTransaccion = 'Creacion de cargo en estado de pago';
                $logTransaccion->idUsuario =  Auth::user()->id;
                $logTransaccion->webclient = $request->userAgent();
                $logTransaccion->descripcionTransaccion = 'Creacion de cargo en ID estado de pago: '.$request->idEstadoPago. ' - Monto del cargo: '.
                $request->monto;
                $logTransaccion->save();

                toastr()->success('Cargo creado exitosamente');
                return redirect('/estados-pagos/edit/'.$request->idEstadoPago);
            }
            else
            {
                $descuento = new Descuento();
                $descuento->idEstadoPago = $request->idEstadoPago;
                $descuento->nombreDescuento = $request->nombre;
                $descuento->descripcionDescuento = $request->descripcion;
                $descuento->montoDescuento = $request->monto;
                $descuento->correspondeADescuentos = $request->correspondeA;
                $descuento->creadoPor = "1";
                $descuento->save();

                $estadoPago = EstadoPago::where('idEstadoPago', $request->idEstadoPago)->first();
                $estadoPago->subtotal = $estadoPago->subtotal - $request->monto;
                if($estadoPago->saldo > 0 && $estadoPago->saldo <= $request->monto)
                {
                    $estadoPago->saldo = $estadoPago->saldo - $request->monto;
                }
                $estadoPago->save();

                $logTransaccion = new LogTransaccion();
                $logTransaccion->tipoTransaccion = 'Creacion de descuento en estado de pago';
                $logTransaccion->idUsuario =  Auth::user()->id;
                $logTransaccion->webclient = $request->userAgent();
                $logTransaccion->descripcionTransaccion = 'Creacion de descuento en ID estado de pago: '.$request->idEstadoPago. '
                 - Monto del descuento: '.$request->monto;
                $logTransaccion->save();

                DB::commit();
                toastr()->success('Descuento creado exitosamente');
                return redirect('/estados-pagos/edit/'.$request->idEstadoPago);
            }
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        }
    }
    public function destroyCargoDescuento(Request $request)
    {
        try{
            $user = Auth::user();
            DB::beginTransaction();
            if($request->tipo == 1)
            {
                $cargo = Cargo::where('idCargo', $request->id)->first();
                $cargo->delete();

                $estadoPago = EstadoPago::where('idEstadoPago', $cargo->idEstadoPago)->first();
                $estadoPago->subtotal = $estadoPago->subtotal - $cargo->montoCargo;
                if($estadoPago->saldo > 0)
                {
                    $estadoPago->saldo = $estadoPago->saldo - $cargo->montoCargo;
                }
                $estadoPago->save();

                $logTransaccion = new LogTransaccion();
                $logTransaccion->tipoTransaccion = 'Eliminacion de cargo en estado de pago';
                $logTransaccion->idUsuario =  Auth::user()->id;
                $logTransaccion->webclient = $request->userAgent();
                $logTransaccion->descripcionTransaccion = 'Eliminacion de cargo en ID estado de pago: '.$request->idEstadoPago. 
                ' - Monto del cargo: '.$cargo->montoCargo;
                $logTransaccion->save();

                DB::commit();
                toastr()->success('Cargo eliminado exitosamente');
                return redirect('/estados-pagos/edit/'.$request->idEstadoPago);
            }
            else
            {
                $descuento = Descuento::where('idDescuento', $request->id)->first();
                $descuento->delete();

                $estadoPago = EstadoPago::where('idEstadoPago', $descuento->idEstadoPago)->first();
                $estadoPago->subtotal = $estadoPago->subtotal + $descuento->montoDescuento;
                if($estadoPago->saldo > 0 && $estadoPago->saldo <= $descuento->montoDescuento)
                {
                    $estadoPago->saldo = $estadoPago->saldo + $descuento->montoDescuento;
                }
                $estadoPago->save();

                $logTransaccion = new LogTransaccion();
                $logTransaccion->tipoTransaccion = 'Eliminacion de descuento en estado de pago';
                $logTransaccion->idUsuario =  Auth::user()->id;
                $logTransaccion->webclient = $request->userAgent();
                $logTransaccion->descripcionTransaccion = 'Eliminacion de descuento en ID estado de pago: '.$request->idEstadoPago. 
                ' - Monto del descuento: '.$descuento->montoDescuento;
                $logTransaccion->save();

                DB::commit();
                toastr()->success('Descuento eliminado exitosamente');
                return redirect('/estados-pagos/edit/'.$request->idEstadoPago);
            }
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        }
    }
    public function indexPagos($id)
    {
        $user = Auth::user();
        $estadoPago = EstadoPago::select('estados_pagos.*', 'estados.nombreEstado', 'estados.idEstado', 'contratos_arriendos.nombreArrendatario',
        'contratos_arriendos.rutArrendatario', 'contratos_arriendos.apellidoArrendatario', 'contratos_arriendos.direccionPropiedad',
        'contratos_arriendos.nombreComunaPropiedad', 'contratos_arriendos.block', 'contratos_arriendos.idContratoArriendo')
        ->join('estados', 'estados.idEstado', '=', 'estados_pagos.idEstado')
        ->join('contratos_arriendos', 'contratos_arriendos.idContratoArriendo', '=', 'estados_pagos.idContrato')
        ->where('estados_pagos.idEstadoPago', '=', $id)
        ->first();
        $pagos = Pago::select('pagos.*', 'metodos_pagos.nombreMetodoPago', 'documentos_pagos.idTipoDocumento', 'documentos_pagos.rutaDocumento')
        ->join('metodos_pagos', 'metodos_pagos.idMetodosPagos', '=', 'pagos.idMetodoPago')
        ->leftjoin('documentos_pagos', 'documentos_pagos.idPago', '=', 'pagos.idPago')
        ->where('pagos.tokenEstadoPago', $estadoPago->token)
        ->get();
        $metodosPagos = MetodoPago::get();
        return view ('back-office.estadoPago.pagos', compact('user', 'estadoPago', 'pagos', 'metodosPagos'));
    }
    public function pagoManual(Request $request)
    {
        try
        {
            DB::beginTransaction();
            $idEstadoDelPago = Crypt::decrypt($request->idEstadoPago);
            $estadoDePago = EstadoPago::where('idEstadoPago', '=', $idEstadoDelPago)->first();
            $estadoDePagoAntes = EstadoPago::where('idEstadoPago', '=', $idEstadoDelPago)->first();
            if($estadoDePago->idEstado == 48)
            {
                toastr()->info('Este pago ya se realizó');
                return redirect('/estados-pagos/mostrar/'.$estadoDePago->idContrato);
            }
            if($estadoDePago->saldo > 0)
            {
                $estadoDePago->totalPagado = $estadoDePago->totalPagado + $estadoDePago->saldo;
            }
            else
            {
                $estadoDePago->totalPagado = $estadoDePago->subtotal;
            }
            $estadoDePago->saldo = 0; 
            $estadoDePago->idEstado = 48;
            $estadoDePago->save();

            $estadoDePago = EstadoPago::select('estados_pagos.*', 'contratos_arriendos.idPropiedad')
                            ->join('contratos_arriendos', 'estados_pagos.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
                            ->where('estados_pagos.idEstadoPago', '=', $idEstadoDelPago)
                            ->first();

            $nuevoPago = new Pago();
            $nuevoPago->tokenEstadoPago = $estadoDePago->token;
            if($estadoDePagoAntes->saldo > 0)
            {
                $nuevoPago->montoPago = $estadoDePagoAntes->saldo;
            }
            else
            {
                $nuevoPago->montoPago = $estadoDePago->subtotal;
            }
            $nuevoPago->numeroTransaccion = $request->numeroTransaccion;
            $nuevoPago->comentarios = $request->comentarios;
            $nuevoPago->idMetodoPago = $request->idMetodoPago;
            $nuevoPago->tokenPago = uniqid();
            $nuevoPago->creadoPor = Auth::user()->name.' '.Auth::user()->apellido;
            $nuevoPago->save();
            if($request->file('documento'))
            {
                $nombreArchivo = "";
                $file =  $request['documento'];
                $nombreArchivo = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/documentosPagos/', $nombreArchivo);

                $nuevoDocumento = new DocumentoPago();
                $nuevoDocumento->idPropiedad = $estadoDePago->idPropiedad;
                $nuevoDocumento->idEstadoPago = $idEstadoDelPago;
                $nuevoDocumento->idPago = $nuevoPago->idPago;
                $nuevoDocumento->idTipoDocumento = 49;
                $nuevoDocumento->rutaDocumento = $nombreArchivo;
                $nuevoDocumento->subidoPor = Auth::user()->name.' '.Auth::user()->apellido;
                $nuevoDocumento->validado = 0;
                $nuevoDocumento->save();
            }

            $estadosDePago = EstadoPago::select('estados_pagos.*', 'estados.nombreEstado', 'propiedades.nombrePropiedad', 'contratos_arriendos.nombreContrato', 
            'users.rut', 'contratos_arriendos.nombreArrendatario', 'contratos_arriendos.apellidoArrendatario', 'contratos_arriendos.direccionArrendatario',
             'contratos_arriendos.nombreComunaArrendatario', 'contratos_arriendos.nombreRegionArrendatario', 'contratos_arriendos.correoArrendatario', 
             'contratos_arriendos.numeroTelefonoArrendatario', 'contratos_arriendos.direccionPropiedad', 'contratos_arriendos.nombreComunaPropiedad', 
             'contratos_arriendos.nombreRegionPropiedad', 'metodos_pagos.nombreMetodoPago', 'propiedades.direccion', 'propiedades.numero', 
             'tipos_monedas.nombreMoneda', 'contratos_arriendos.idTiempoPagoGarantia', 'pagos.montoPago', 'pagos.idPago', 'pagos.created_at as fechaPagado')
                    ->join('estados', 'estados_pagos.idEstado', '=', 'estados.idEstado')
                    ->join('contratos_arriendos', 'estados_pagos.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
                    ->join('propiedades', 'contratos_arriendos.idPropiedad', '=', 'propiedades.id')
                    ->join('users', 'contratos_arriendos.idUsuarioArrendatario', '=', 'users.id')
                    ->join('tipos_monedas', 'contratos_arriendos.idMoneda', '=', 'tipos_monedas.idMoneda')
                    ->join('pagos', 'pagos.tokenEstadoPago', '=', 'estados_pagos.token')
                    ->join('metodos_pagos', 'metodos_pagos.idMetodosPagos', '=', 'pagos.idMetodoPago')
                    ->where('pagos.idPago', '=', $nuevoPago->idPago)->first();

            $descuentos = Descuento::where('idEstadoPago', '=', $idEstadoDelPago)->get();
            $cargos = Cargo::where('idEstadoPago', '=', $idEstadoDelPago)->get();
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
            EnvioPagoArriendo::dispatch( $nuevoPago->idPago, $cargos, $descuentos, $totalDescuento, $totalCargo);
            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Pago rapido de estado de pago';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Pago rapido en ID estado de pago: '.$idEstadoDelPago. 
            ' - Monto del pago: '.$nuevoPago->montoPago = $estadoDePago->subtotal. ' - Numero de transaccion: '.$request->numeroTransaccion;
            $logTransaccion->save();
            DB::commit();
            toastr()->success('Pago realizado con exito', 'Operacion exitosa');
            //return view('pagos.factura', compact('estadosDePago', 'cargos', 'descuentos', 'totalDescuento', 'totalCargo'));
            return redirect('/estados-pagos/mostrar/'.$estadoDePago->idContrato);
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        }
    }
    public function pagoManualDesdeIndex(Request $request)
    {
        try
        {
            DB::beginTransaction();
            $idEstadoDelPago = Crypt::decrypt($request->idEstadoPago);
            $estadoDePago = EstadoPago::where('idEstadoPago', '=', $idEstadoDelPago)->first();
            if($estadoDePago->idEstado == 48)
            {
                toastr()->info('Este pago ya se realizó');
                return redirect('/estados-pagos/pagos/'.$idEstadoDelPago);
            } 
            if($estadoDePago->saldo > 0)
            {
                if(($estadoDePago->saldo - $request->montoAPagar) == 0)
                {
                    $estadoDePago->idEstado = 48;
                }
                elseif(($estadoDePago->saldo - $request->montoAPagar) > 0)
                {
                    $estadoDePago->idEstado = 47;
                }
                else
                {
                    toastr()->info('Monto a pagar exede el saldo o Subtotal');
                    return redirect('/estados-pagos/pagos/'.$idEstadoDelPago);
                }
            }
            else
            {
                if(($estadoDePago->subtotal - $request->montoAPagar) == 0)
                {
                    $estadoDePago->idEstado = 48;
                }
                elseif(($estadoDePago->subtotal - $request->montoAPagar) > 0)
                {
                    $estadoDePago->idEstado = 47;
                }
                else
                {
                    toastr()->info('Monto a pagar exede el saldo o Subtotal');
                    return redirect('/estados-pagos/pagos/'.$idEstadoDelPago);
                }
            }
            
            $estadoDePago->totalPagado = $estadoDePago->totalPagado + $request->montoAPagar;
            if($estadoDePago->saldo > 0)
            {
                $estadoDePago->saldo = $estadoDePago->saldo - $request->montoAPagar;
            }
            else
            {
                $estadoDePago->saldo = $estadoDePago->subtotal - $request->montoAPagar;
            }
            $estadoDePago->save();

            $estadoDePago = EstadoPago::select('estados_pagos.*', 'contratos_arriendos.idPropiedad')
                            ->join('contratos_arriendos', 'estados_pagos.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
                            ->where('estados_pagos.idEstadoPago', '=', $idEstadoDelPago)
                            ->first();

            $nuevoPago = new Pago();
            $nuevoPago->tokenEstadoPago = $estadoDePago->token;
            $nuevoPago->montoPago = $request->montoAPagar;
            $nuevoPago->numeroTransaccion = $request->numeroTransaccion;
            $nuevoPago->comentarios = $request->comentarios;
            $nuevoPago->idMetodoPago = $request->idMetodoPago;
            $nuevoPago->tokenPago = uniqid();
            $nuevoPago->creadoPor = Auth::user()->name.' '.Auth::user()->apellido;
            $nuevoPago->save();
            if($request->file('documento'))
            {
                $nombreArchivo = "";
                $file =  $request['documento'];
                $nombreArchivo = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/documentosPagos/', $nombreArchivo);

                $nuevoDocumento = new DocumentoPago();
                $nuevoDocumento->idPropiedad = $estadoDePago->idPropiedad;
                $nuevoDocumento->idEstadoPago = $idEstadoDelPago;
                $nuevoDocumento->idPago = $nuevoPago->idPago;
                $nuevoDocumento->idTipoDocumento = 49;
                $nuevoDocumento->rutaDocumento = $nombreArchivo;
                $nuevoDocumento->subidoPor = Auth::user()->name.' '.Auth::user()->apellido;
                $nuevoDocumento->validado = 0;
                $nuevoDocumento->save();
            }

            $estadosDePago = EstadoPago::select('estados_pagos.*', 'estados.nombreEstado', 'propiedades.nombrePropiedad', 'contratos_arriendos.nombreContrato', 
            'users.rut', 'contratos_arriendos.nombreArrendatario', 'contratos_arriendos.apellidoArrendatario', 'contratos_arriendos.direccionArrendatario',
             'contratos_arriendos.nombreComunaArrendatario', 'contratos_arriendos.nombreRegionArrendatario', 'contratos_arriendos.correoArrendatario', 
             'contratos_arriendos.numeroTelefonoArrendatario', 'contratos_arriendos.direccionPropiedad', 'contratos_arriendos.nombreComunaPropiedad', 
             'contratos_arriendos.nombreRegionPropiedad', 'metodos_pagos.nombreMetodoPago', 'propiedades.direccion', 'propiedades.numero', 
             'tipos_monedas.nombreMoneda', 'contratos_arriendos.idTiempoPagoGarantia', 'pagos.montoPago', 'pagos.idPago', 'pagos.created_at as fechaPagado')
                    ->join('estados', 'estados_pagos.idEstado', '=', 'estados.idEstado')
                    ->join('contratos_arriendos', 'estados_pagos.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
                    ->join('propiedades', 'contratos_arriendos.idPropiedad', '=', 'propiedades.id')
                    ->join('users', 'contratos_arriendos.idUsuarioArrendatario', '=', 'users.id')
                    ->join('tipos_monedas', 'contratos_arriendos.idMoneda', '=', 'tipos_monedas.idMoneda')
                    ->join('pagos', 'pagos.tokenEstadoPago', '=', 'estados_pagos.token')
                    ->join('metodos_pagos', 'metodos_pagos.idMetodosPagos', '=', 'pagos.idMetodoPago')
                    ->where('pagos.idPago', '=', $nuevoPago->idPago)->first();

            $descuentos = Descuento::where('idEstadoPago', '=', $idEstadoDelPago)->get();
            $cargos = Cargo::where('idEstadoPago', '=', $idEstadoDelPago)->get();
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
            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Pago Manual de estado de pago';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Pago Manual en ID estado de pago: '.$idEstadoDelPago. 
            ' - Monto del pago: '.$request->montoAPagar. ' - Numero de transaccion: '.$request->numeroTransaccion;
            $logTransaccion->save();
            DB::commit();
            toastr()->success('Pago Manual realizado con exito', 'Operacion exitosa');
            //return view('pagos.factura', compact('estadosDePago', 'cargos', 'descuentos', 'totalDescuento', 'totalCargo'));
            return redirect('/estados-pagos/pagos/'.$idEstadoDelPago);
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        }
    }
    public function deletePago(Request $request)
    {
        try{
            DB::beginTransaction();
            $pago = Pago::where('idPago', $request->idPago)->firstOrFail();
            $estadoPago = EstadoPago::where('idEstadoPago', '=', $request->idEstadoPago)->firstOrFail();
            $estadoPago->fill($request->all());
            $estadoPago->totalPagado = $estadoPago->totalPagado - $pago->montoPago;
            $estadoPago->saldo = $estadoPago->saldo + $pago->montoPago;

            $fechaHoy = $mesYAnio = Carbon::now()->format('Y-m-d');
            $fechaVencimiento = $mesYAnio = Carbon::parse($estadoPago->fechaVencimiento)->format('Y-m-d');

            if(($estadoPago->saldo + $pago->montoPago) > 0)
            {
                if($fechaHoy > $fechaVencimiento)
                {
                    $estadoPago->idEstado = 50;
                }
                else
                {
                    $estadoPago->idEstado = 47;
                }
            }
            $estadoPago->save();

            $documentoPago = DocumentoPago::where('idPago', $pago->idPago)->first();
            if($documentoPago)
            {
                File::delete(public_path('documentosPagos/' . $documentoPago->rutaDocumento));
                $documentoPago->delete();
            }
            $pago->delete();
            
            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Eliminación de Pago';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Eliminación de Pago: '. $estadoPago->idEstadoPago. ' - Monto de reversa: '.
            $pago->montoPago.' - Numero de transaccion: '. $pago->numeroTransaccion;
            $logTransaccion->save();

            DB::commit();
            toastr()->success('Estado de pago eliminado exitosamente', 'Operación exitosa');
            return redirect('/estados-pagos/pagos/'.$request->idEstadoPago);
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        }
    }
    public function recordarPago()
    {
        try{
            Mail::to(['beenjaahp@hotmail.com',
                'beenjaahp@gmail.com'])
            ->send(new YaSeEncuentraDisponibleTuPago());
            return redirect('/home');
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage());
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage());
            DB::rollback();
            return $e->getMessage();
        }
    }
    //consulta deuda
    public function condeu01req(Request $request)
    {
        try{
            $rutSinGuion = str_replace('-', '', $request->rut);
            $convenio = getenv("OTROS_PAGOS_COVENIO");

            $usuario = Usuario::where('rutDos', '=', $rutSinGuion)
            ->join('usuarios_codigo_empresas', 'usuarios_codigo_empresas.idUsuario', '=', 'usuarios.idUsuario')
            ->where('eliminado', '!=', 1)
            ->where('usuarios_codigo_empresas.codigoEmpresa', '=', 3)
            ->firstOrFail();
            Session::put('idEstadoPago', $request->idEstadoPago);
            if($usuario)
            {
                if($usuario->idTipoRut == 2)
                {
                    $tipoRut = '07';
                }
                else
                {
                    $tipoRut = '01';
                }
                //return $rutSinGuion;
                //return redirect()->to('https://pre.otrospagos.com/publico/portal/enlace?id='.$convenio.'&idcli='.$rutSinGuion.'&tiidc='.$tipoRut.'');
                $url = 'https://otrospagos.com/publico/portal/enlace?id='.$convenio.'&idcli='.$rutSinGuion.'&tiidc='.$tipoRut.'';
                session()->flash('url', $url);
                return redirect()->back();
            }
            else
            {
                toastr()->info('Usuario no encontrado');
                return back();
            }
        } catch (ModelNotFoundException $e) {
            toastr()->error('Usuario no encontrado');
            DB::rollback();
            return back();
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage());
            DB::rollback();
            return back();
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado');
            DB::rollback();
            return back();
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage());
            DB::rollback();
            return back();
        }
    }
    public function cambiarAMoroso()
    {
        $fechaActual = date('Y-m-d');
        $estadosDePago = EstadoPago::join('contratos_arriendos', 'estados_pagos.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
                    ->where('contratos_arriendos.idEstado', '=',61)
                    ->where('estados_pagos.idEstado', '=', 47)
                    ->get();
        if($estadosDePago)
        {
            foreach($estadosDePago as $estadosDePagos)
            {
                if($estadosDePagos->fechaVencimiento < $fechaActual)
                {
                    $estadosDePagos->idEstado = 49;
                    $estadosDePagos->save();
                }
            }
        }
        return 'finalizo';
    }
    public function cambiarAVencido()
    {
        $fechaActual = date('Y-m-d');
        $estadosDePago = EstadoPago::join('contratos_arriendos', 'estados_pagos.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
                    ->where('contratos_arriendos.idEstado', '=',61)
                    ->where('estados_pagos.idEstado', '=', 49)
                    ->get();
        $dias = ParametroGeneral::where('parametroGeneral', '=', 'DIAS PARA PASAR PAGO A VENCIDO')->first();
        if($estadosDePago)
        {
            foreach($estadosDePago as $estadosDePagos)
            {
                if(date("Y-m-d",strtotime($estadosDePagos->fechaVencimiento."+ ".$dias->valorParametro." days")) < $fechaActual)
                {
                    $estadosDePagos->idEstado = 50;
                    $estadosDePagos->save();
                }
            }
        }
        return 'finalizo';
    }
    public function agregarPorcentajeAMorosos()
    {
        $anioActual = date('Y');
        $mesActual = date('m');
        $estadosDePago = EstadoPago::select('estados_pagos.*')
        ->join('contratos_arriendos', 'estados_pagos.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
        ->where('contratos_arriendos.idEstado', '=',61)
        ->whereIn('estados_pagos.idEstado', [49, 50])
        ->whereMonth('estados_pagos.fechaVencimiento', '=', $mesActual)
        ->whereYear('estados_pagos.fechaVencimiento', '=', $anioActual)
        ->get();

        if($estadosDePago)
        {
            foreach($estadosDePago as $estadosDePagos)
            {
                $montoACargar = ($estadosDePagos->subtotal * 1) / 100;
                $cargo = new Cargo();
                $cargo->idEstadoPago = $estadosDePagos->idEstadoPago;
                $cargo->nombreCargo = 'Intereses por mora';
                $cargo->descripcionCargo = 'Intereses por mora';
                $cargo->montoCargo = $montoACargar;
                $cargo->correspondeA = 2;
                $cargo->cargoValidado = 1;
                $cargo->creadoPor = "Automatico";
                $cargo->save();
                DB::commit();

                $estadoPago = EstadoPago::where('idEstadoPago', $estadosDePagos->idEstadoPago)->first();
                $estadoPago->subtotal = $estadoPago->subtotal + $montoACargar;
                if($estadoPago->saldo > 0)
                {
                    $estadoPago->saldo = $estadoPago->saldo + $montoACargar;
                }
                $estadoPago->save();

                $logTransaccion = new LogTransaccion();
                $logTransaccion->tipoTransaccion = 'Creacion de cargo en estado de pago Automatico por MULTA';
                $logTransaccion->webclient = 'CRON AUTOMATICO';
                $logTransaccion->descripcionTransaccion = 'Creacion de cargo en estado de pago Automatico por MULTA ID estado de pago: '.$estadosDePagos->idEstadoPago. ' - Monto del cargo: '.
                $montoACargar;
                $logTransaccion->save();
            }
        }
        return "Listo";
    }
    public function tokenizarEstadosPagos(Request $request)
    {
        try{
            $estadosPagos = EstadoPago::where('token', null)->get();
            if($estadosPagos)
            {
                foreach ($estadosPagos as $estadoPago) 
                {
                    $estadoPago->token = uniqid();
                    $estadoPago->save();
                }
            }
            return "ok";
        } catch (ModelNotFoundException $e) {
            toastr()->error('Usuario no encontrado');
            DB::rollback();
            return back();
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage());
            DB::rollback();
            return back();
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado');
            DB::rollback();
            return back();
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage());
            DB::rollback();
            return back();
        }
    }
}
