<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\EnvioPagoInversionista;
use App\Exports\LiquidacionInversionista;
use App\Exports\MandatosExport;
use App\EstadosPagosMandatarios;
use App\UsuarioCuentaBancaria;
use App\MandatoAdministracion;
use App\PlanAdministracion;
use App\ParametroGeneral;
use App\ContratoArriendo;
use App\NumerosEnLetras;
use App\LogTransaccion;
use App\EstadoPago;
use App\Propiedad;
use App\Descuento;
use App\Moneda;
use App\Estado;
use App\Cargo;
use App\User;
use Carbon\Carbon;
use Session;
use Auth;
use DB;
class MandatoAdministracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $mandatosAdministracion = MandatoAdministracion::select('mandatos_propiedad.*', 'estados.nombreEstado', 'propiedades.direccion', 
        'propiedades.numero', 'propiedades.block', 'planes.nombre as nombrePlan', 'planes.comisionAdministracion')
        ->join('propiedades', 'mandatos_propiedad.idPropiedad', '=', 'propiedades.id')
        ->join('estados', 'estados.idEstado', '=', 'mandatos_propiedad.idEstadoMandato')
        ->join('planes', 'planes.id', '=', 'mandatos_propiedad.idPlan')
        ->get();
        return view('back-office.mandatos.index', compact('user', 'mandatosAdministracion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $propiedad = Propiedad::select('propiedades.id', 'rut', 'rolPropiedad', 'nombrePropiedad', 'propiedades.nombrePropiedad', 'propiedades.direccion', 'propiedades.numero', 'region.nombre as nombreRegion', 
        'comuna.nombre as nombreComuna', 'propiedades.idNivelUsoPropiedad', 'niveles_uso_propiedad.nombreNivelUsoPropiedad', 'propiedades.valorArriendo')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('niveles_uso_propiedad', 'propiedades.idNivelUsoPropiedad', '=', 'niveles_uso_propiedad.idNivelUsoPropiedad')
        ->where('propiedades.id', '=', $request->propiedad)
        ->first();
        $planes = PlanAdministracion::get();
        $user = Auth::user();
        $tiposMonedas = Moneda::all();
        $usuarios = User::get();
        $estadosContrato = Estado::whereIn('idTipoEstado', [14, 18])->get();
        $porcentajeComision = ParametroGeneral::where('parametroGeneral', '=', 'PORCENTAJE DE COMISION')->first();
        return view ('back-office.mandatos.create', compact('propiedad', 'tiposMonedas', 'usuarios', 'estadosContrato', 'user', 'porcentajeComision', 'planes'));
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
            $mandatoActivo = MandatoAdministracion::where('idPropiedad', '=', $request->idPropiedad)
            ->where('idEstadoMandato', '=', 61)
            ->first();
            if($mandatoActivo)
            {
                DB::rollback();
                toastr()->warning('Ya existe un mandato activo para esta propiedad');
                return redirect()->back();
            }
            $usuarioCuentaBancaria = UsuarioCuentaBancaria::where('idUsuarioCuentaBancaria', '=', $request->cuentaBancaria)
            ->join('bancos', 'bancos.idBanco', '=', 'usuarios_cuentas_bancarias.idBanco')
            ->first();

            $planElegido = PlanAdministracion::where('id', $request->idPlan)->first();
            
            $propietario = User::where('rut', '=', $request->rutPropietario)->first();
            $nuevoMandato = new MandatoAdministracion();
            $nuevoMandato->notarizado = 0;
            $nuevoMandato->fill($request->all());
            $nuevoMandato->idPropietario = $propietario->id;
            $nuevoMandato->tokenMandato = uniqid();
            $nuevoMandato->conTraspaso = 0;
            $nuevoMandato->porcentajeComision = (float) str_replace(['.', ','], ['', '.'], $planElegido->comisionAdministracion);
            $nuevoMandato->idEstadoMandato = $request->idEstadoMandato;
            $nuevoMandato->creadoPor = Auth::user()->name.' '.Auth::user()->apellido;
            if($usuarioCuentaBancaria)
            {
                $nuevoMandato->cuentaPropietario = $usuarioCuentaBancaria->numeroCuenta;
                $nuevoMandato->bancoPropietario = $usuarioCuentaBancaria->nombreBanco;
                $nuevoMandato->idUsuarioCuentaBancaria = $usuarioCuentaBancaria->idUsuarioCuentaBancaria;
            }
            else
            {
                DB::rollback();
                toastr()->warning('No existe cuenta bancaria para este propietario');
                return redirect()->back();
            }
            $contrato = ContratoArriendo::where('idPropiedad', '=', $request->idPropiedad)
            ->where('idEstado', 61)
            ->first();
            if($contrato)
            {
                $contrato->idMandato = $nuevoMandato->idMandatoPropiedad;
                $contrato->save();

                $nuevoMandato->idContrato = $contrato->idContratoArriendo;
                $nuevoMandato->idArrendatario = $contrato->idUsuarioArrendatario;
                $nuevoMandato->rutArrendatario = $contrato->rutArrendatario;
                $nuevoMandato->nombreArrendatario = $contrato->nombreArrendatario;
                $nuevoMandato->apellidoArrendatario = $contrato->apellidoArrendatario;
                $nuevoMandato->correoArrendatario = $contrato->correoArrendatario;
                $nuevoMandato->telefonoArrendatario = $contrato->numeroTelefonoArrendatario;
            }
            if($request->seguroDeArriendo)
            {
                $nuevoMandato->seguroDeArriendo = 1;
            }
            else
            {
                $nuevoMandato->seguroDeArriendo = 0;
            }
            $nuevoMandato->save();
            $nuevoLogTransaccion = new LogTransaccion();
            $nuevoLogTransaccion->tipoTransaccion = 'Nuevo mandato en propiedad: '.$nuevoMandato->direccionPropiedad. ' '. $nuevoMandato->departamentoPropiedad;
            $nuevoLogTransaccion->idUsuario =  Auth::user()->id;
            $nuevoLogTransaccion->webclient = $request->userAgent();
            $nuevoLogTransaccion->descripcionTransaccion = 'Nuevo mandato en propiedad: '.$nuevoMandato->direccionPropiedad. ' '. $nuevoMandato->departamentoPropiedad.
            ' '. $nuevoMandato->comunaPropiedad. ' Propietario: '. $nuevoMandato->nombrePropietario. ' '. $nuevoMandato->apellidoPropietario. ' Rut: '.
            $nuevoMandato->rutPropietario;
            $nuevoLogTransaccion->save();
            DB::commit();
            toastr()->success('Mandato creado exitosamente');
            return redirect('/mandatos');
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
        $mandatosAdministracion = MandatoAdministracion::select('mandatos_propiedad.*','propiedades.id', 'propiedades.nombrePropiedad', 
        'estados.nombreEstado', 'estados.idEstado', 'planes.nombre as nombrePlan', 'planes.comisionAdministracion')
        ->join('propiedades', 'mandatos_propiedad.idPropiedad', '=', 'propiedades.id')
        ->join('estados', 'estados.idEstado', '=', 'mandatos_propiedad.idEstadoMandato')
        ->join('planes', 'planes.id', '=', 'mandatos_propiedad.idPlan')
        ->where('propiedades.id', '=', $id)
        ->get();
        $propiedad = Propiedad::where('id', $id)->first();
        return view ('back-office.mandatos.indexForProperties', compact('user', 'mandatosAdministracion', 'propiedad'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mandato = MandatoAdministracion::where('idMandatoPropiedad', $id)->first();
        $planes = PlanAdministracion::get();
        $user = Auth::user();
        $tiposMonedas = Moneda::all();
        $usuarios = User::get();
        $estadosContrato = Estado::whereIn('idTipoEstado', [14, 18])->get();
        $porcentajeComision = ParametroGeneral::where('parametroGeneral', '=', 'PORCENTAJE DE COMISION')->first();
        $usuariosCuentasBancarias = UsuarioCuentaBancaria::join('bancos', 'bancos.idBanco', '=', 'usuarios_cuentas_bancarias.idBanco')
        ->join('tipos_cuentas_bancos', 'tipos_cuentas_bancos.idTipoCuenta', '=', 'usuarios_cuentas_bancarias.idTipoCuenta')
        ->where('idUsuario', $mandato->idPropietario)
        ->get();
        $propiedad = Propiedad::select('propiedades.id', 'rut', 'rolPropiedad', 'nombrePropiedad', 'propiedades.nombrePropiedad', 'propiedades.direccion', 'propiedades.numero', 'region.nombre as nombreRegion', 
        'comuna.nombre as nombreComuna', 'propiedades.idNivelUsoPropiedad', 'niveles_uso_propiedad.nombreNivelUsoPropiedad', 'propiedades.valorArriendo')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('niveles_uso_propiedad', 'propiedades.idNivelUsoPropiedad', '=', 'niveles_uso_propiedad.idNivelUsoPropiedad')
        ->where('propiedades.id', '=', $mandato->idPropiedad)
        ->first();
        return view ('back-office.mandatos.edit', compact('mandato', 'tiposMonedas', 'usuarios', 'estadosContrato', 'user', 'porcentajeComision', 
        'planes', 'usuariosCuentasBancarias', 'propiedad'));
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

            $planElegido = PlanAdministracion::where('id', $request->idPlan)->first();
            $usuarioCuentaBancaria = UsuarioCuentaBancaria::where('idUsuarioCuentaBancaria', '=', $request->cuentaBancaria)
            ->join('bancos', 'bancos.idBanco', '=', 'usuarios_cuentas_bancarias.idBanco')
            ->first();
            
            $propietario = User::where('rut', '=', $request->rutPropietario)->first();
            $actualizarMandato = MandatoAdministracion::where('idMandatoPropiedad', $id)->first();
            $actualizarMandato->fill($request->all());
            $actualizarMandato->idPropietario = $propietario->id;
            $actualizarMandato->idEstadoMandato = $request->idEstadoMandato;
            $actualizarMandato->porcentajeComision = (float) str_replace(['.', ','], ['', '.'], $planElegido->comisionAdministracion);
            $actualizarMandato->creadoPor = Auth::user()->name.' '.Auth::user()->apellido;
            if($usuarioCuentaBancaria)
            {
                $actualizarMandato->cuentaPropietario = $usuarioCuentaBancaria->numeroCuenta;
                $actualizarMandato->bancoPropietario = $usuarioCuentaBancaria->nombreBanco;
                $actualizarMandato->idUsuarioCuentaBancaria = $usuarioCuentaBancaria->idUsuarioCuentaBancaria;
            }
            else
            {
                DB::rollback();
                toastr()->warning('No existe cuenta bancaria para este propietario');
                return redirect()->back();
            }
            $contrato = ContratoArriendo::where('idPropiedad', '=', $request->idPropiedad)
            ->where('idEstado', 61)
            ->first();
            if($contrato)
            {
                $contrato->idMandato = $actualizarMandato->idMandatoPropiedad;
                $contrato->save();

                $actualizarMandato->idContrato = $contrato->idContratoArriendo;
                $actualizarMandato->idArrendatario = $contrato->idUsuarioArrendatario;
                $actualizarMandato->rutArrendatario = $contrato->rutArrendatario;
                $actualizarMandato->nombreArrendatario = $contrato->nombreArrendatario;
                $actualizarMandato->apellidoArrendatario = $contrato->apellidoArrendatario;
                $actualizarMandato->correoArrendatario = $contrato->correoArrendatario;
                $actualizarMandato->telefonoArrendatario = $contrato->numeroTelefonoArrendatario;
            }
            if($request->seguroDeArriendo)
            {
                $actualizarMandato->seguroDeArriendo = 1;
            }
            else
            {
                $actualizarMandato->seguroDeArriendo = 0;
            }
            $actualizarMandato->save();
            $nuevoLogTransaccion = new LogTransaccion();
            $nuevoLogTransaccion->tipoTransaccion = 'Actualizar mandato en propiedad: '.$actualizarMandato->direccionPropiedad. ' '. $actualizarMandato->departamentoPropiedad;
            $nuevoLogTransaccion->idUsuario =  Auth::user()->id;
            $nuevoLogTransaccion->webclient = $request->userAgent();
            $nuevoLogTransaccion->descripcionTransaccion = 'Actualizar mandato en propiedad: '.$actualizarMandato->direccionPropiedad. ' '. $actualizarMandato->departamentoPropiedad.
            ' '. $actualizarMandato->comunaPropiedad. ' Propietario: '. $actualizarMandato->nombrePropietario. ' '. $actualizarMandato->apellidoPropietario. ' Rut: '.
            $actualizarMandato->rutPropietario;
            $nuevoLogTransaccion->save();
            DB::commit();
            toastr()->success('Mandato actualizado exitosamente');
            return redirect('/mandatos');
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
        try {
            DB::beginTransaction();
            $eliminarMandato = MandatoAdministracion::where('idMandatoPropiedad', '=', $request->id)->first();
            $eliminarMandato->idEstadoMandato = 62;
            $eliminarMandato->save();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Eliminacion de Mandato de administracion';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Eliminacion de Mandato de administracion en propiedad: '. $eliminarMandato->direccionPropiedad. ' - Propietario: '.
            $eliminarMandato->nombrePropietario.' '. $eliminarMandato->apellidoPropietario;
            $logTransaccion->save();

            toastr()->success('Mandato eliminado correctamente');
            DB::commit();
            return redirect('/mandatos');
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado');
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
    public function imprimirMandatoAdministracion(Request $request)
    {
        $mandatoAdministracion = MandatoAdministracion::select('mandatos_propiedad.*', 'user1.name as nombrePropietario', 'user1.apellido as apellidoPropietario', 
        'user1.rut as rutPropietario','user1.direccion as direccionPropietario', 'user1.numero as numeroPropietario', 'comuna1.nombre as comunaPropietario', 
        'user1.email as correoPropietario', 'user1.nacionalidad as nacionalidadPropietario', 'user1.estadoCivil as estadoCivilPropietario', 
        'user1.profesion as profesionPropietario', 'region1.nombre as regionPropietario', 'propiedades.id', 'estados.nombreEstado', 'estados.idEstado',
        'propiedades.direccion', 'propiedades.numero', 'propiedades.block', 'region.nombre as nombreRegion', 'comuna.nombre as nombreComuna', 
        'propiedades.usoGoceBodega', 'propiedades.codigoBodega', 'propiedades.usoGoceEstacionamiento', 'propiedades.codigoEstacionamiento',
        'propiedades.habitacion', 'propiedades.bano', 'planes.nombre as nombrePlan', 'usuarios_cuentas_bancarias.numeroCuenta', 'bancos.nombreBanco',
        'usuarios_cuentas_bancarias.correoAsociado', 'user1.telefono', 'planes.comisionCorretaje', 'planes.comisionAdministracion', 'propiedades.rolPropiedad')
        ->join('propiedades', 'mandatos_propiedad.idPropiedad', '=', 'propiedades.id')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('estados', 'estados.idEstado', '=', 'mandatos_propiedad.idEstadoMandato')
        ->join('users as user1', 'user1.id', '=', 'mandatos_propiedad.idPropietario')
        ->join('comuna as comuna1', 'comuna1.id', '=', 'user1.idComuna')
        ->join('region as region1', 'region1.id', '=', 'user1.idRegion')
        ->join('planes', 'planes.id', '=', 'mandatos_propiedad.idPlan')
        ->leftjoin('usuarios_cuentas_bancarias', 'usuarios_cuentas_bancarias.idUsuarioCuentaBancaria', '=', 'mandatos_propiedad.idUsuarioCuentaBancaria')
        ->leftjoin('bancos', 'bancos.idBanco', '=', 'usuarios_cuentas_bancarias.idBanco')
        ->where('mandatos_propiedad.idMandatoPropiedad', '=', $request->id)
        ->first();
        //str_replace(',', '.', $mandatoAdministracion->comisionAdministracion);
        $comisionCorretajePalabras = NumerosEnLetras::convertir($mandatoAdministracion->comisionCorretaje,'',false,'');
        $porcentajeAdministracionPalabras = NumerosEnLetras::convertir(str_replace(',', '.', $mandatoAdministracion->comisionAdministracion),'coma', true,'');
        $diasEnPalabras = NumerosEnLetras::convertir($mandatoAdministracion->diaPago,'',false,'');
        if($mandatoAdministracion->idPlan == 2)
        {
            $pdf = \PDF::loadView('prints.printMandatosAdministracion1', compact('mandatoAdministracion', 'comisionCorretajePalabras', 'porcentajeAdministracionPalabras',
            'diasEnPalabras'));
            return $pdf->download('mandato-administracion.pdf');
        }
        elseif($mandatoAdministracion->idPlan == 2)
        {
            $pdf = \PDF::loadView('prints.printMandatosAdministracion2', compact('mandatoAdministracion', 'comisionCorretajePalabras', 'porcentajeAdministracionPalabras',
            'diasEnPalabras'));
            return $pdf->download('mandato-administracion.pdf');
        }
        elseif($mandatoAdministracion->idPlan == 3)
        {
            $pdf = \PDF::loadView('prints.printMandatosAdministracion3', compact('mandatoAdministracion', 'comisionCorretajePalabras', 'porcentajeAdministracionPalabras',
            'diasEnPalabras'));
            return $pdf->download('mandato-administracion.pdf');
        }
        elseif($mandatoAdministracion->idPlan == 4)
        {
            $pdf = \PDF::loadView('prints.printMandatosAdministracion4', compact('mandatoAdministracion', 'comisionCorretajePalabras', 'porcentajeAdministracionPalabras',
            'diasEnPalabras'));
            return $pdf->download('mandato-administracion.pdf');
        }
        elseif($mandatoAdministracion->idPlan == 1)
        {
            $pdf = \PDF::loadView('prints.printMandatosAdministracion4', compact('mandatoAdministracion', 'comisionCorretajePalabras', 'porcentajeAdministracionPalabras',
            'diasEnPalabras'));
            return $pdf->download('mandato-administracion.pdf');
        }
        elseif($mandatoAdministracion->idPlan == 6)
        {
            $pdf = \PDF::loadView('prints.printMandatosAdministracion4', compact('mandatoAdministracion', 'comisionCorretajePalabras', 'porcentajeAdministracionPalabras',
            'diasEnPalabras'));
            return $pdf->download('mandato-administracion.pdf');
        }
        elseif($mandatoAdministracion->idPlan == 10)
        {
            $pdf = \PDF::loadView('prints.printMandatosAdministracion4', compact('mandatoAdministracion', 'comisionCorretajePalabras', 'porcentajeAdministracionPalabras',
            'diasEnPalabras'));
            return $pdf->download('mandato-administracion.pdf');
        }
        else
        {
            toastr()->error('No existe documento para imprimir Mandato, Favor contacte a Administrador');
            return redirect('/mandatos');
        }
    }
    public function exportExcel()
    {
		try {
            return Excel::download(new MandatosExport, 'mandatos.xlsx');
		} catch (QueryException $e) {
			toastr()->error($e->getMessage());
			return back();
		} catch (ModelNotFoundException $e) {
			toastr()->error('Imagen no encontrada');
			return back();
		} catch (Exception $e) {
			toastr()->error('Se ha producido un error, favor intente nuevamente');
			return back();
		}
	}
    public function liquidacionInversionista()
    {
        $user = Auth::user();
        $anio = date('Y');
        $mes = date('mm');
        $filtro = EstadosPagosMandatarios::selectRaw('year(fechaDePago) year, month(fechaDePago) month, count(*) data')
            ->groupby('year','month')
            ->get();
        $filtroDos = MandatoAdministracion::selectRaw('diaPago, count(*) data')
            ->groupby('diaPago')
            ->get();
        $estadosPagosMandatarios = null;
        $tipo = '';
        return view('back-office.mandatos.liquidacionInversionista', compact('filtro', 'estadosPagosMandatarios', 'filtroDos', 'user', 'anio', 'mes', 'tipo'));
    }
    public function buscarPagosMandatosMes(Request $request)
    {
        $user = Auth::user();
        $anio = substr($request->filtro, -4);
        $mes = substr($request->filtro, 0, -5);
        $tipo = $request->tipo;
        if($request->tipo == 1)
        {
            $estadosPagosMandatarios = EstadosPagosMandatarios::select('estados_pagos_mandatarios.*', 'estados.nombreEstado', 'propiedades.direccion', 'propiedades.numero', 
            'mandatos_propiedad.rutPropietario', 'users.rut', 'propiedades.block', 'mandatos_propiedad.nombrePropietario', 'mandatos_propiedad.apellidoPropietario', 
            'mandatos_propiedad.nombreArrendatario', 'mandatos_propiedad.apellidoArrendatario', 'mandatos_propiedad.rutArrendatario')
            ->join('estados', 'estados_pagos_mandatarios.idEstado', '=', 'estados.idEstado')
            ->join('mandatos_propiedad', 'estados_pagos_mandatarios.idMandatoPropiedad', '=', 'mandatos_propiedad.idMandatoPropiedad')
            ->join('propiedades', 'mandatos_propiedad.idPropiedad', '=', 'propiedades.id')
            ->join('users', 'mandatos_propiedad.idPropietario', '=', 'users.id')
            ->leftjoin('contratos_arriendos', 'estados_pagos_mandatarios.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
            ->whereIn('estados_pagos_mandatarios.idEstado', [69, 67])
            ->whereMonth('estados_pagos_mandatarios.fechaDePago', '=', $mes)
            ->whereYear('estados_pagos_mandatarios.fechaDePago', '=', $anio)
            ->orderBy('users.name', 'ASC')
            ->get();
        }
        else
        {
            $estadosPagosMandatarios = EstadosPagosMandatarios::select('estados_pagos_mandatarios.*', 'estados.nombreEstado', 'propiedades.direccion', 'propiedades.numero', 
            'mandatos_propiedad.rutPropietario', 'users.rut', 'propiedades.block', 'mandatos_propiedad.nombrePropietario', 'mandatos_propiedad.apellidoPropietario', 
            'mandatos_propiedad.nombreArrendatario', 'mandatos_propiedad.apellidoArrendatario', 'mandatos_propiedad.rutArrendatario')
            ->join('estados', 'estados_pagos_mandatarios.idEstado', '=', 'estados.idEstado')
            ->join('mandatos_propiedad', 'estados_pagos_mandatarios.idMandatoPropiedad', '=', 'mandatos_propiedad.idMandatoPropiedad')
            ->join('propiedades', 'mandatos_propiedad.idPropiedad', '=', 'propiedades.id')
            ->join('users', 'mandatos_propiedad.idPropietario', '=', 'users.id')
            ->leftjoin('contratos_arriendos', 'estados_pagos_mandatarios.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
            ->where('estados_pagos_mandatarios.idEstado', '=', 68)
            ->whereMonth('estados_pagos_mandatarios.fechaDePago', '=', $mes)
            ->whereYear('estados_pagos_mandatarios.fechaDePago', '=', $anio)
            ->orderBy('users.name', 'ASC')
            ->get();
        }
        $filtro = EstadosPagosMandatarios::selectRaw('year(fechaDePago) year, month(fechaDePago) month, count(*) data')
            ->groupby('year','month')
            ->get();
        $filtroDos = MandatoAdministracion::selectRaw('diaPago, count(*) data')
            ->groupby('diaPago')
            ->get();
        $estados = Estado::where('idTipoEstado', '=', 16)->get();
        return view('back-office.mandatos.liquidacionInversionista', compact('estadosPagosMandatarios', 'filtro', 'anio', 'mes', 'filtroDos', 'estados', 'tipo', 'user'));
    }
    public function comisionMandato($mes, $anio)
    {
        //$mes = date("06");
        //$anio = date("2020");
        $mandatos = MandatoAdministracion::select('mandatos_propiedad.*', 'planes.comisionAdministracion')
        ->join('planes', 'planes.id', '=', 'mandatos_propiedad.idPlan')
        ->where('mandatos_propiedad.idEstadoMandato', '=', 61)
        ->get();
        $mandatosConTraspaso = MandatoAdministracion::select('mandatos_propiedad.*', 'planes.comisionAdministracion')
            ->join('planes', 'planes.id', '=', 'mandatos_propiedad.idPlan')
            ->where('mandatos_propiedad.conTraspaso', '=', 1)
            ->whereMonth('mandatos_propiedad.hasta', '=', $mes)
            ->whereYear('mandatos_propiedad.hasta', '=', $anio)
            ->where('mandatos_propiedad.idEstadoMandato', '=', 61)
            ->get();
        foreach ($mandatosConTraspaso as $mandatoTraspaso) 
        {
            $mandatos->push($mandatoTraspaso);
        }

        //NOTA: falta verificar que el estado de pago no este liquidado, ya que si no, se actualiza el estado de pago. si esta liquidado, se realiza ningun proceso.
        foreach ($mandatos as $mandato) 
        {
            $first = Carbon::create($mandato->desde);
            $second = Carbon::create($mandato->hasta);
            $fechaInicioMandato = Carbon::parse($mandato->desde);

            //revisando si existen mandatos que empezaron con traspaso y verificando que los mandatos con estado activo no sobrepasen la fecha del mes y el año
            if(Carbon::create($anio, $mes, 01, 3)->between($first, $second) || $fechaInicioMandato->format("d") != '01' && $fechaInicioMandato->format("m") == $mes && $fechaInicioMandato->format("Y") == $anio)
            {
                //estado de pago de contrato
                $estadosPagos = EstadoPago::select('estados_pagos.*')->join('contratos_arriendos', 'estados_pagos.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
                    ->where('contratos_arriendos.idPropiedad', '=', $mandato->idPropiedad)
                    ->where('contratos_arriendos.idEstado', '=', 61)
                    ->whereMonth('estados_pagos.fechaVencimiento', '=', $mes)
                    ->whereYear('estados_pagos.fechaVencimiento', '=', $anio)
                    ->first();
                //ultimo estado de pago en caso de que sea por dias proporcionales
                if(empty($estadosPagos))
                {
                    $estadosPagos = EstadoPago::select('estados_pagos.*')
                    ->join('contratos_arriendos', 'estados_pagos.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
                    ->where('contratos_arriendos.idPropiedad', '=', $mandato->idPropiedad)
                    ->whereMonth('estados_pagos.fechaVencimiento', '=', $mes)
                    ->whereYear('estados_pagos.fechaVencimiento', '=', $anio)
                    ->whereMonth('contratos_arriendos.fechaTerminoContrato', '=', $mes)
                    ->whereYear('contratos_arriendos.fechaTerminoContrato', '=', $anio)
                    ->first();
                }
                //fin de ultimo estado de pago
                //ver si ya existe el estado de pago a crear
                $existe = EstadosPagosMandatarios::where('idMandatoPropiedad', '=', $mandato->idMandatoPropiedad)
                    ->whereMonth('estados_pagos_mandatarios.fechaDePago', '=', $mes)
                    ->whereYear('estados_pagos_mandatarios.fechaDePago', '=', $anio)
                    ->first();
                //obteniendo cargos y descuentos
                $cargos = null;
                $descuentos = null;
                if($estadosPagos)
                {
                    $cargos = Cargo::select(DB::raw("SUM(montoCargo) as cargo"))
                    ->where('idEstadoPago', '=', $estadosPagos->idEstadoPago)
                    ->first();
                    $descuentos = Descuento::select(DB::raw("SUM(montoDescuento) as descuento"))
                    ->where('idEstadoPago', '=', $estadosPagos->idEstadoPago)
                    ->first();

                    $multasNoValidadas = Cargo::select(DB::raw("SUM(montoCargo) as multaNoValidada"))
                    ->where('idEstadoPago', '=', $estadosPagos->idEstadoPago)
                    ->where('idEstado', '=', 88)
                    ->where('cargoValidado', '=', 0)
                    ->first();

                    $cargosDescuentos = (($cargos) ? $cargos->cargo : 0) - (($descuentos) ? $descuentos->descuento : 0) - (($multasNoValidadas) ? $multasNoValidadas->multaNoValidada : 0);
                }
                //en caso de que hayan dos mandatos el mismo mes
                $opcion = 0;
                if($fechaInicioMandato->format("d") != '01' && $fechaInicioMandato->format("m") == $mes && $fechaInicioMandato->format("Y") == $anio)
                {
                    $fechaDesde = Carbon::parse($mandato->desde);
                    $mesDesde = Carbon::parse($mandato->desde);
                    $diaInicio = "30";
                    $mesInicio = $mesDesde->month;
                    $anioInicio = $mesDesde->year;
                    $diasProporcionalesMandato = $fechaDesde->diffInDays($diaInicio.'-'.$mesInicio.'-'.$anioInicio) + 1;
                    $opcion = 1;

                }
                if($mandato->conTraspaso == 1)
                {
                    $fechaDesde = Carbon::parse($mandato->hasta);
                    $mesDesde = Carbon::parse($mandato->hasta);
                    $diaFin = "01";
                    $mesFin = $mesDesde->month;
                    $anioFin = $mesDesde->year;
                    $diasProporcionalesTraspaso = $fechaDesde->diffInDays($diaFin.'-'.$mesFin.'-'.$anioFin) + 1;
                    $opcion = 2;
                }
                //fin de dos mandatos el mismo mes
                //primero los pagos garantizados que son los mas importantes
                if($mandato->seguroDeArriendo == 1)
                {
                    DB::beginTransaction();
                    //preguntamos si existe para crear o actualizar, el primer caso actualiza el estado de pago
                    if($existe)
                    {
                        //vemos si ya esta liquidado el estado de pago de mandatario
                        if($existe->idEstado == 68)
                        {
                            //vemos si ya se actualizo manualmente
                            if($existe->editadoManual == 1)
                            {
                                DB::rollback();
                            }
                            else
                            {
                                //si no se actualizó, modificar diariamente
                                //Si no hay estado de pago de arriendo no se genera el estado de pago
                                if($estadosPagos)
                                {
                                    $existe->idMandatoPropiedad = $mandato->idMandatoPropiedad;
                                    $existe->idEstado = 68;
                                    $existe->idEstadoPago = $estadosPagos->idEstadoPago;
                                    $existe->idContrato = $estadosPagos->idContrato;
                                    $existe->garantia = (($estadosPagos->garantia) ? $estadosPagos->garantia : 0) + (($estadosPagos->garantiaDos) ? $estadosPagos->garantiaDos : 0);
                                    if($opcion == 1)
                                    {
                                        $existe->montoAPagar = (($estadosPagos->arriendoMensual / 30) * $diasProporcionalesMandato);
                                        $existe->montoPagado = (($estadosPagos->totalPagado / 30) * $diasProporcionalesMandato);
                                        $existe->garantia = (($existe->garantia / 30) * $diasProporcionalesMandato);

                                    }
                                    elseif($opcion == 2)
                                    {
                                        $existe->montoAPagar = (($estadosPagos->arriendoMensual / 30) * $diasProporcionalesTraspaso);
                                        $existe->montoPagado = (($estadosPagos->totalPagado / 30) * $diasProporcionalesTraspaso);
                                        $existe->garantia = (($existe->garantia / 30) * $diasProporcionalesTraspaso);
                                    }
                                    else
                                    {
                                        $existe->montoAPagar = $estadosPagos->arriendoMensual;
                                        $existe->montoPagado = $estadosPagos->totalPagado;
                                        $existe->garantia = $existe->garantia;
                                    }
                                    
                                    $existe->cargosAbonos = $cargosDescuentos;
                                    //$existe->tieneTraspasoSaldo = $estadosPagos->traspasoSaldo;
                                    //revisamos si existen cargos o descuentos asociados al propietario
                                    //opcion 0 en where corresponde a propietario
                                    if($estadosPagos)
                                    {
                                        $cargosPropietario = Cargo::select(DB::raw("SUM(montoCargo) as cargo"))
                                            ->where('idEstadoPago', '=', $estadosPagos->idEstadoPago)
                                            ->where('correspondeA', '=', 1)
                                            ->first();
                                        $descuentosPropietario = Descuento::select(DB::raw("SUM(montoDescuento) as descuento"))
                                            ->where('idEstadoPago', '=', $estadosPagos->idEstadoPago)
                                            ->where('correspondeADescuentos', '=', 1)
                                            ->first();
                                        $valor = (($cargosPropietario) ? $cargosPropietario->cargo : 0) - (($descuentosPropietario) ? $descuentosPropietario->descuento : 0);
                                        if($opcion == 1)
                                        {
                                            $valor = (($valor / 30) * $diasProporcionalesMandato);
                                        }
                                        if($opcion == 2)
                                        {
                                            $valor = (($valor / 30) * $diasProporcionalesTraspaso);
                                        }
                                    }
                                    $comisionIntegra = 0;
                                    //si es porcentaje,  se calcula el porcentaje de comision primero y despues se le resta al arriendo, se trabaja con el MONTO ARRIENDO, ya que si no ha realizado pagos el arrendatario, de igual forma se le paga al propietario
                                    if($mandato->comisionAdministracion != null || $mandato->comisionAdministracion == "0")
                                    {
                                        //porcentaje comision
                                        $porcentajeRestado = (100 - (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion));
                                        //seguro de arriendo si es que existe
                                        $existe->montoALiquidarPropietario = (($existe->montoAPagar * $porcentajeRestado)/100) + (($valor) ? $valor : 0);

                                        $ivaComision = ((($existe->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19) - (($existe->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100);

                                        $existe->montoALiquidarPropietario = $existe->montoALiquidarPropietario - $ivaComision;
 
                                        //nuevo proporcional
                                        if($opcion == 1)
                                        {
                                            if($existe->montoPagado > 0)
                                            {
                                                $existe->montoComision = ((((($existe->montoAPagar / 30) * $diasProporcionalesMandato) * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                                $existe->comisionCorretaje = (($estadosPagos->comision / 30) * $diasProporcionalesMandato);
                                            }
                                            else
                                            {
                                                $existe->montoComision = ((($existe->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                                $existe->comisionCorretaje = 0;
                                            }
                                        }
                                        elseif($opcion == 2)
                                        {
                                            if($existe->montoPagado > 0)
                                            {
                                                $existe->montoComision = ((((($existe->montoAPagar / 30) * $diasProporcionalesTraspaso) * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                                $existe->comisionCorretaje = (($estadosPagos->comision / 30) * $diasProporcionalesTraspaso);
                                            }
                                            else
                                            {
                                                $existe->montoComision = ((($existe->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                                $existe->comisionCorretaje = 0;
                                            }
                                        }
                                        else
                                        {
                                            if($existe->montoPagado > 0)
                                            {
                                                $existe->montoComision = ((($existe->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                                $existe->comisionCorretaje = (($estadosPagos->comision) ? $estadosPagos->comision : 0);
                                            }
                                            else
                                            {
                                                $existe->montoComision = ((($existe->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                                $existe->comisionCorretaje = 0;
                                            }
                                           
                                        }
                                        $comisionIntegra = ((($existe->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                        if($existe->montoComision < 1)
                                        {
                                            $existe->saldoArrastre = 0;
                                            $existe->montoComision = 0;
                                            $existe->valorSeguroArriendo = 0;
                                        }
                                        else
                                        {
                                            $existe->montoComision = $existe->montoComision;
                                            $existe->saldoArrastre = (($existe->montoPagado - $existe->montoALiquidarPropietario) - $existe->garantia - $existe->comisionCorretaje) - $comisionIntegra;
                                        }
                                        $existe->aLiquidarSinDeuda = $existe->montoALiquidarPropietario;
                                    }
                                    if($existe->montoPagado < $existe->montoAPagar)
                                    {
                                        $existe->montoALiquidarPropietario = $existe->montoALiquidarPropietario;
                                    }
                                    else
                                    {
                                        $existe->montoALiquidarPropietario = $existe->montoALiquidarPropietario;
                                    }
                                    $existe->editadoManual = 0;
                                    $existe->save();
                                    DB::commit();
                                }
                                else
                                {
                                    DB::rollback();
                                    continue;
                                }
                            }
                        }
                        else
                        {
                            DB::rollback();
                            continue;
                        }
                    }
                    else
                    {
                        // si no existe, se crea le nuevo estado de pago
                        if($estadosPagos)
                        {
                            $estadoPagoMandato = new EstadosPagosMandatarios();
                            $estadoPagoMandato->idMandatoPropiedad = $mandato->idMandatoPropiedad;
                            $estadoPagoMandato->idEstado = 68;
                            $estadoPagoMandato->idEstadoPago = $estadosPagos->idEstadoPago;
                            $estadoPagoMandato->idContrato = $estadosPagos->idContrato;
                            $estadoPagoMandato->garantia = (($estadosPagos->garantia) ? $estadosPagos->garantia : 0) + (($estadosPagos->garantiaDos) ? $estadosPagos->garantiaDos : 0);
                            if($estadosPagos->totalPagado > 0)
                            {
                                if($opcion == 1)
                                {
                                    $estadoPagoMandato->montoAPagar = (($estadosPagos->arriendoMensual / 30) * $diasProporcionalesMandato);
                                    $estadoPagoMandato->montoPagado = (($estadosPagos->totalPagado / 30) * $diasProporcionalesMandato);
                                    $estadoPagoMandato->garantia = (($estadoPagoMandato->garantia / 30) * $diasProporcionalesMandato);

                                }
                                elseif($opcion == 2)
                                {
                                    $estadoPagoMandato->montoAPagar = (($estadosPagos->arriendoMensual / 30) * $diasProporcionalesTraspaso);
                                    $estadoPagoMandato->montoPagado = (($estadosPagos->totalPagado / 30) * $diasProporcionalesTraspaso);
                                    $estadoPagoMandato->garantia = (($estadoPagoMandato->garantia / 30) * $diasProporcionalesTraspaso);
                                }
                                else
                                {
                                    $estadoPagoMandato->montoAPagar = $estadosPagos->arriendoMensual;
                                    $estadoPagoMandato->montoPagado = $estadosPagos->totalPagado;
                                    $estadoPagoMandato->garantia = $estadoPagoMandato->garantia;
                                }
                            }
                            else
                            {                                    
                                $estadoPagoMandato->montoAPagar = $estadosPagos->arriendoMensual;
                                $estadoPagoMandato->montoPagado = 0;
                                $estadoPagoMandato->garantia = $estadoPagoMandato->garantia;
                            }
                            
                            
                            $estadoPagoMandato->cargosAbonos = $cargosDescuentos;
                            //$existe->tieneTraspasoSaldo = $estadosPagos->traspasoSaldo;
                            //revisamos si existen cargos o descuentos asociados al propietario
                            //opcion 0 en where corresponde a propietario
                            if($estadosPagos)
                            {
                                $cargosPropietario = Cargo::select(DB::raw("SUM(montoCargo) as cargo"))
                                    ->where('idEstadoPago', '=', $estadosPagos->idEstadoPago)
                                    ->where('correspondeA', '=', 1)
                                    ->first();
                                $descuentosPropietario = Descuento::select(DB::raw("SUM(montoDescuento) as descuento"))
                                    ->where('idEstadoPago', '=', $estadosPagos->idEstadoPago)
                                    ->where('correspondeADescuentos', '=', 1)
                                    ->first();
                                $valor = (($cargosPropietario) ? $cargosPropietario->cargo : 0) - (($descuentosPropietario) ? $descuentosPropietario->descuento : 0);
                                if($opcion == 1)
                                {
                                    $valor = (($valor / 30) * $diasProporcionalesMandato);
                                }
                                if($opcion == 2)
                                {
                                    $valor = (($valor / 30) * $diasProporcionalesTraspaso);
                                }
                            }
                            $comisionIntegra = 0;
                            //si es porcentaje,  se calcula el porcentaje de comision primero y despues se le resta al arriendo, se trabaja con el MONTO ARRIENDO, ya que si no ha realizado pagos el arrendatario, de igual forma se le paga al propietario
                            if($mandato->comisionAdministracion != null || $mandato->comisionAdministracion == "0")
                            {
                                $porcentajeRestado = (100 - (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion));
                                $ivaComision = ((($estadoPagoMandato->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19) - (($estadoPagoMandato->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100);
                                if($opcion == 1)
                                {
                                    if($estadoPagoMandato->montoPagado > 0)
                                    {
                                        $estadoPagoMandato->montoComision = ((((($estadoPagoMandato->montoAPagar / 30) * $diasProporcionalesMandato) * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                        $estadoPagoMandato->comisionCorretaje = (($estadosPagos->comision / 30) * $diasProporcionalesMandato);
                                        $estadoPagoMandato->montoALiquidarPropietario = (($estadoPagoMandato->montoAPagar * $porcentajeRestado)/100) + (($valor) ? $valor : 0);
                                        $estadoPagoMandato->montoALiquidarPropietario = $estadoPagoMandato->montoALiquidarPropietario - $ivaComision;
                                    }
                                    else
                                    {
                                        $estadoPagoMandato->montoComision = 0;
                                        $estadoPagoMandato->comisionCorretaje = 0;
                                        $estadoPagoMandato->montoALiquidarPropietario = 0;
                                    }
                                }
                                elseif($opcion == 2)
                                {
                                    if($estadoPagoMandato->montoPagado > 0)
                                    {
                                        $estadoPagoMandato->montoComision = ((((($estadoPagoMandato->montoAPagar / 30) * $diasProporcionalesTraspaso) * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                        $estadoPagoMandato->comisionCorretaje = (($estadosPagos->comision / 30) * $diasProporcionalesTraspaso);
                                        $estadoPagoMandato->montoALiquidarPropietario = (($estadoPagoMandato->montoAPagar * $porcentajeRestado)/100) + (($valor) ? $valor : 0);
                                        $estadoPagoMandato->montoALiquidarPropietario = $estadoPagoMandato->montoALiquidarPropietario - $ivaComision;
                                    }
                                    else
                                    {
                                        $estadoPagoMandato->montoComision = 0;
                                        $estadoPagoMandato->comisionCorretaje = 0;
                                        $estadoPagoMandato->montoALiquidarPropietario = 0;
                                    }
                                }
                                else
                                {
                                    if($estadoPagoMandato->montoPagado > 0)
                                    {
                                        $estadoPagoMandato->montoComision = ((($estadoPagoMandato->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                        $estadoPagoMandato->comisionCorretaje = (($estadosPagos->comision) ? $estadosPagos->comision : 0);
                                        $estadoPagoMandato->montoALiquidarPropietario = (($estadoPagoMandato->montoAPagar * $porcentajeRestado)/100) + (($valor) ? $valor : 0);
                                        $estadoPagoMandato->montoALiquidarPropietario = $estadoPagoMandato->montoALiquidarPropietario - $ivaComision;
                                    }
                                    else
                                    {
                                        $estadoPagoMandato->montoComision = 0;
                                        $estadoPagoMandato->comisionCorretaje = 0;
                                        $estadoPagoMandato->montoALiquidarPropietario = 0;
                                    }
                                   
                                }
                                $comisionIntegra = ((($estadoPagoMandato->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                if($estadoPagoMandato->montoComision < 1)
                                {
                                    $estadoPagoMandato->saldoArrastre = 0;
                                    $estadoPagoMandato->montoComision = 0;
                                    $estadoPagoMandato->valorSeguroArriendo = 0;
                                }
                                else
                                {
                                    $estadoPagoMandato->montoComision = $estadoPagoMandato->montoComision;
                                    $estadoPagoMandato->saldoArrastre = (($estadoPagoMandato->montoPagado - $estadoPagoMandato->montoALiquidarPropietario) - $estadoPagoMandato->garantia - $estadoPagoMandato->comisionCorretaje) - $comisionIntegra;
                                }
                                $estadoPagoMandato->aLiquidarSinDeuda = $estadoPagoMandato->montoALiquidarPropietario;
                            }
                            if($estadoPagoMandato->montoPagado < $estadoPagoMandato->montoAPagar)
                            {
                                $estadoPagoMandato->montoALiquidarPropietario = $estadoPagoMandato->montoALiquidarPropietario;
                            }
                            else
                            {
                                $estadoPagoMandato->montoALiquidarPropietario = $estadoPagoMandato->montoALiquidarPropietario;
                            }
                            $estadoPagoMandato->editadoManual = 0;
                            //solo al crear se debe colocar la fecha
                            $estadoPagoMandato->fechaDePago = "".$anio."-".$mes."-".$mandato->diaPago."";
                            $estadoPagoMandato->save();
                            DB::commit();
                        }
                        else
                        {
                            //no esta arrendado
                            DB::rollback();
                            continue;
                        }
                    }
                }
                else
                {
                    //preguntamos si existe para crear o actualizar, el primer caso actualiza el estado de pago
                    if($existe)
                    {
                        //vemos si ya esta liquidado el estado de pago de mandatario
                        if($existe->idEstado == 68)
                        {
                            //vemos si ya se actualizo manualmente
                            if($existe->editadoManual == 1)
                            {
                                DB::rollback();
                            }
                            else
                            {
                                //si no se actualizó, modificar diariamente
                                //Si no hay estado de pago de arriendo no se genera el estado de pago
                                if($estadosPagos)
                                {
                                    $existe->idMandatoPropiedad = $mandato->idMandatoPropiedad;
                                    $existe->idEstado = 68;
                                    $existe->idEstadoPago = $estadosPagos->idEstadoPago;
                                    $existe->idContrato = $estadosPagos->idContrato;
                                    $existe->garantia = (($estadosPagos->garantia) ? $estadosPagos->garantia : 0) + (($estadosPagos->garantiaDos) ? $estadosPagos->garantiaDos : 0);
                                    if($estadosPagos->totalPagado > 0)
                                    {
                                        if($opcion == 1)
                                        {
                                            $existe->montoAPagar = (($estadosPagos->arriendoMensual / 30) * $diasProporcionalesMandato);
                                            $existe->montoPagado = (($estadosPagos->totalPagado / 30) * $diasProporcionalesMandato);
                                            $existe->garantia = (($existe->garantia / 30) * $diasProporcionalesMandato);

                                        }
                                        elseif($opcion == 2)
                                        {
                                            $existe->montoAPagar = (($estadosPagos->arriendoMensual / 30) * $diasProporcionalesTraspaso);
                                            $existe->montoPagado = (($estadosPagos->totalPagado / 30) * $diasProporcionalesTraspaso);
                                            $existe->garantia = (($existe->garantia / 30) * $diasProporcionalesTraspaso);
                                        }
                                        else
                                        {
                                            $existe->montoAPagar = $estadosPagos->arriendoMensual;
                                            $existe->montoPagado = $estadosPagos->totalPagado;
                                            $existe->garantia = $existe->garantia;
                                        }
                                    }
                                    else
                                    {                                    
                                        $existe->montoAPagar = $estadosPagos->arriendoMensual;
                                        $existe->montoPagado = 0;
                                        $existe->garantia = $existe->garantia;
                                    }
                                    
                                    
                                    $existe->cargosAbonos = $cargosDescuentos;
                                    //$existe->tieneTraspasoSaldo = $estadosPagos->traspasoSaldo;
                                    //revisamos si existen cargos o descuentos asociados al propietario
                                    //opcion 0 en where corresponde a propietario
                                    if($estadosPagos)
                                    {
                                        $cargosPropietario = Cargo::select(DB::raw("SUM(montoCargo) as cargo"))
                                            ->where('idEstadoPago', '=', $estadosPagos->idEstadoPago)
                                            ->where('correspondeA', '=', 1)
                                            ->first();
                                        $descuentosPropietario = Descuento::select(DB::raw("SUM(montoDescuento) as descuento"))
                                            ->where('idEstadoPago', '=', $estadosPagos->idEstadoPago)
                                            ->where('correspondeADescuentos', '=', 1)
                                            ->first();
                                        $valor = (($cargosPropietario) ? $cargosPropietario->cargo : 0) - (($descuentosPropietario) ? $descuentosPropietario->descuento : 0);
                                        if($opcion == 1)
                                        {
                                            $valor = (($valor / 30) * $diasProporcionalesMandato);
                                        }
                                        if($opcion == 2)
                                        {
                                            $valor = (($valor / 30) * $diasProporcionalesTraspaso);
                                        }
                                    }
                                    $comisionIntegra = 0;
                                    //si es porcentaje,  se calcula el porcentaje de comision primero y despues se le resta al arriendo, se trabaja con el MONTO ARRIENDO, ya que si no ha realizado pagos el arrendatario, de igual forma se le paga al propietario
                                    if($mandato->comisionAdministracion != null || $mandato->comisionAdministracion == "0")
                                    {
                                        $porcentajeRestado = (100 - (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion));
                                        $ivaComision = ((($existe->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19) - (($existe->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100);
                                        if($opcion == 1)
                                        {
                                            if($existe->montoPagado > 0)
                                            {
                                                $existe->montoComision = ((((($existe->montoAPagar / 30) * $diasProporcionalesMandato) * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                                $existe->comisionCorretaje = (($estadosPagos->comision / 30) * $diasProporcionalesMandato);
                                                $existe->montoALiquidarPropietario = (($existe->montoAPagar * $porcentajeRestado)/100) + (($valor) ? $valor : 0);
                                                $existe->montoALiquidarPropietario = $existe->montoALiquidarPropietario - $ivaComision;
                                            }
                                            else
                                            {
                                                $existe->montoComision = 0;
                                                $existe->comisionCorretaje = 0;
                                                $existe->montoALiquidarPropietario = 0;
                                            }
                                        }
                                        elseif($opcion == 2)
                                        {
                                            if($existe->montoPagado > 0)
                                            {
                                                $existe->montoComision = ((((($existe->montoAPagar / 30) * $diasProporcionalesTraspaso) * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                                $existe->comisionCorretaje = (($estadosPagos->comision / 30) * $diasProporcionalesTraspaso);
                                                $existe->montoALiquidarPropietario = (($existe->montoAPagar * $porcentajeRestado)/100) + (($valor) ? $valor : 0);
                                                $existe->montoALiquidarPropietario = $existe->montoALiquidarPropietario - $ivaComision;
                                            }
                                            else
                                            {
                                                $existe->montoComision = 0;
                                                $existe->comisionCorretaje = 0;
                                                $existe->montoALiquidarPropietario = 0;
                                            }
                                        }
                                        else
                                        {
                                            if($existe->montoPagado > 0)
                                            {
                                                $existe->montoComision = ((($existe->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                                $existe->comisionCorretaje = (($estadosPagos->comision) ? $estadosPagos->comision : 0);
                                                $existe->montoALiquidarPropietario = (($existe->montoAPagar * $porcentajeRestado)/100) + (($valor) ? $valor : 0);
                                                $existe->montoALiquidarPropietario = $existe->montoALiquidarPropietario - $ivaComision;
                                            }
                                            else
                                            {
                                                $existe->montoComision = 0;
                                                $existe->comisionCorretaje = 0;
                                                $existe->montoALiquidarPropietario = 0;
                                            }
                                           
                                        }
                                        $comisionIntegra = ((($existe->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                        if($existe->montoComision < 1)
                                        {
                                            $existe->saldoArrastre = 0;
                                            $existe->montoComision = 0;
                                            $existe->valorSeguroArriendo = 0;
                                        }
                                        else
                                        {
                                            $existe->montoComision = $existe->montoComision;
                                            $existe->saldoArrastre = (($existe->montoPagado - $existe->montoALiquidarPropietario) - $existe->garantia - $existe->comisionCorretaje) - $comisionIntegra;
                                        }
                                        $existe->aLiquidarSinDeuda = $existe->montoALiquidarPropietario;
                                    }
                                    if($existe->montoPagado < $existe->montoAPagar)
                                    {
                                        $existe->montoALiquidarPropietario = $existe->montoALiquidarPropietario;
                                    }
                                    else
                                    {
                                        $existe->montoALiquidarPropietario = $existe->montoALiquidarPropietario;
                                    }
                                    $existe->editadoManual = 0;
                                    $existe->save();
                                    DB::commit();
                                }
                                else
                                {
                                    DB::rollback();
                                    continue;
                                }
                            }
                        }
                        else
                        {
                            DB::rollback();
                            continue;
                        }
                    }
                    else
                    {
                        // si no existe, se crea le nuevo estado de pago
                        if($estadosPagos)
                        {
                            $estadoPagoMandato = new EstadosPagosMandatarios();
                            $estadoPagoMandato->idMandatoPropiedad = $mandato->idMandatoPropiedad;
                            $estadoPagoMandato->idEstado = 68;
                            $estadoPagoMandato->idEstadoPago = $estadosPagos->idEstadoPago;
                            $estadoPagoMandato->idContrato = $estadosPagos->idContrato;
                            $estadoPagoMandato->garantia = (($estadosPagos->garantia) ? $estadosPagos->garantia : 0) + (($estadosPagos->garantiaDos) ? $estadosPagos->garantiaDos : 0);
                            
                            if($estadosPagos->totalPagado > 0)
                            {
                                if($opcion == 1)
                                {
                                    $estadoPagoMandato->montoAPagar = (($estadosPagos->arriendoMensual / 30) * $diasProporcionalesMandato);
                                    $estadoPagoMandato->montoPagado = (($estadosPagos->totalPagado / 30) * $diasProporcionalesMandato);
                                    $estadoPagoMandato->garantia = (($estadoPagoMandato->garantia / 30) * $diasProporcionalesMandato);

                                }
                                elseif($opcion == 2)
                                {
                                    $estadoPagoMandato->montoAPagar = (($estadosPagos->arriendoMensual / 30) * $diasProporcionalesTraspaso);
                                    $estadoPagoMandato->montoPagado = (($estadosPagos->totalPagado / 30) * $diasProporcionalesTraspaso);
                                    $estadoPagoMandato->garantia = (($estadoPagoMandato->garantia / 30) * $diasProporcionalesTraspaso);
                                }
                                else
                                {
                                    $estadoPagoMandato->montoAPagar = $estadosPagos->arriendoMensual;
                                    $estadoPagoMandato->montoPagado = $estadosPagos->totalPagado;
                                    $estadoPagoMandato->garantia = $estadoPagoMandato->garantia;
                                }
                            }
                            else
                            {                                    
                                $estadoPagoMandato->montoAPagar = $estadosPagos->arriendoMensual;
                                $estadoPagoMandato->montoPagado = 0;
                                $estadoPagoMandato->garantia = $estadoPagoMandato->garantia;
                            }
                            
                                    
                            $estadoPagoMandato->cargosAbonos = $cargosDescuentos;
                            //$existe->tieneTraspasoSaldo = $estadosPagos->traspasoSaldo;
                            //revisamos si existen cargos o descuentos asociados al propietario
                            //opcion 0 en where corresponde a propietario
                            if($estadosPagos)
                            {
                                $cargosPropietario = Cargo::select(DB::raw("SUM(montoCargo) as cargo"))
                                    ->where('idEstadoPago', '=', $estadosPagos->idEstadoPago)
                                    ->where('correspondeA', '=', 1)
                                    ->first();
                                $descuentosPropietario = Descuento::select(DB::raw("SUM(montoDescuento) as descuento"))
                                    ->where('idEstadoPago', '=', $estadosPagos->idEstadoPago)
                                    ->where('correspondeADescuentos', '=', 1)
                                    ->first();
                                $valor = (($cargosPropietario) ? $cargosPropietario->cargo : 0) - (($descuentosPropietario) ? $descuentosPropietario->descuento : 0);
                                if($opcion == 1)
                                {
                                    $valor = (($valor / 30) * $diasProporcionalesMandato);
                                }
                                if($opcion == 2)
                                {
                                    $valor = (($valor / 30) * $diasProporcionalesTraspaso);
                                }
                            }
                            $comisionIntegra = 0;
                            if($mandato->comisionAdministracion != null || $mandato->comisionAdministracion == "0")
                            {
                                $porcentajeRestado = (100 - (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion));
                                $ivaComision = ((($estadoPagoMandato->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19) - (($estadoPagoMandato->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100);
                                if($opcion == 1)
                                {
                                    if($estadoPagoMandato->montoPagado > 0)
                                    {
                                        $estadoPagoMandato->montoComision = ((((($estadoPagoMandato->montoAPagar / 30) * $diasProporcionalesMandato) * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                        $estadoPagoMandato->comisionCorretaje = (($estadosPagos->comision / 30) * $diasProporcionalesMandato);
                                        $estadoPagoMandato->montoALiquidarPropietario = (($estadoPagoMandato->montoAPagar * $porcentajeRestado)/100) + (($valor) ? $valor : 0);
                                        $estadoPagoMandato->montoALiquidarPropietario = $estadoPagoMandato->montoALiquidarPropietario - $ivaComision;
                                    }
                                    else
                                    {
                                        $estadoPagoMandato->montoComision = 0;
                                        $estadoPagoMandato->comisionCorretaje = 0;
                                        $estadoPagoMandato->montoALiquidarPropietario = 0;
                                    }
                                }
                                elseif($opcion == 2)
                                {
                                    if($estadoPagoMandato->montoPagado > 0)
                                    {
                                        $estadoPagoMandato->montoComision = ((((($estadoPagoMandato->montoAPagar / 30) * $diasProporcionalesTraspaso) * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                        $estadoPagoMandato->comisionCorretaje = (($estadoPagoMandato->comision / 30) * $diasProporcionalesTraspaso);
                                        $estadoPagoMandato->montoALiquidarPropietario = (($estadoPagoMandato->montoAPagar * $porcentajeRestado)/100) + (($valor) ? $valor : 0);
                                        $estadoPagoMandato->montoALiquidarPropietario = $estadoPagoMandato->montoALiquidarPropietario - $ivaComision;
                                    }
                                    else
                                    {
                                        $estadoPagoMandato->montoComision = 0;
                                        $estadoPagoMandato->comisionCorretaje = 0;
                                        $estadoPagoMandato->montoALiquidarPropietario = 0;
                                    }
                                }
                                else
                                {
                                    if($estadoPagoMandato->montoPagado > 0)
                                    {
                                        $estadoPagoMandato->montoComision = ((($estadoPagoMandato->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                        $estadoPagoMandato->comisionCorretaje = (($estadosPagos->comision) ? $estadosPagos->comision : 0);
                                        $estadoPagoMandato->montoALiquidarPropietario = (($estadoPagoMandato->montoAPagar * $porcentajeRestado)/100) + (($valor) ? $valor : 0);
                                        $estadoPagoMandato->montoALiquidarPropietario = $estadoPagoMandato->montoALiquidarPropietario - $ivaComision;
                                    }
                                    else
                                    {
                                        $estadoPagoMandato->montoComision = 0;
                                        $estadoPagoMandato->comisionCorretaje = 0;
                                        $estadoPagoMandato->montoALiquidarPropietario = 0;
                                    }
                                    
                                }
                                $comisionIntegra = ((($estadoPagoMandato->montoAPagar * (float) str_replace(['.', ','], ['', '.'], $mandato->comisionAdministracion)) / 100) * 1.19);
                                if($estadoPagoMandato->montoComision < 1)
                                {
                                    $estadoPagoMandato->saldoArrastre = 0;
                                    $estadoPagoMandato->montoComision = 0;
                                    $estadoPagoMandato->valorSeguroArriendo = 0;
                                }
                                else
                                {
                                    $estadoPagoMandato->montoComision = $estadoPagoMandato->montoComision;
                                    $estadoPagoMandato->saldoArrastre = (($estadoPagoMandato->montoPagado - $estadoPagoMandato->montoALiquidarPropietario) - $estadoPagoMandato->garantia - $estadoPagoMandato->comisionCorretaje) - $comisionIntegra;
                                }
                                $estadoPagoMandato->aLiquidarSinDeuda = $estadoPagoMandato->montoALiquidarPropietario;
                            }
                            if($estadoPagoMandato->montoPagado < $estadoPagoMandato->montoAPagar)
                            {
                                $estadoPagoMandato->montoALiquidarPropietario = $estadoPagoMandato->montoALiquidarPropietario;
                            }
                            else
                            {
                                $estadoPagoMandato->montoALiquidarPropietario = $estadoPagoMandato->montoALiquidarPropietario;
                            }
                            $estadoPagoMandato->editadoManual = 0;
                            //solo al crear se debe colocar la fecha
                            $estadoPagoMandato->fechaDePago = "".$anio."-".$mes."-".$mandato->diaPago."";
                            $estadoPagoMandato->save();
                            DB::commit();
                        }
                        else
                        {
                            DB::rollback();
                            continue;
                        }
                    }
                }
            }
        }
        toastr()->success('Actualizacion planilla mandatarios mes: '. $mes.' año: '.$anio);
        return back();
    }
    public function editarEstadoPagoMandato(Request $request)
    {
        try{
            DB::beginTransaction();
            $id = Crypt::decrypt($request->idEstadoPago);
            $estadoPago = EstadosPagosMandatarios::where('idEstadoPagoMandato', '=', $id)->firstOrFail();
            $estadoPago->montoAPagar = $request->montoAPagar;
            $estadoPago->cargosAbonos = $request->cargosAbonos;
            $estadoPago->montoPagado = $request->montoPagado;
            $estadoPago->garantia = $request->garantia;
            $estadoPago->montoComision = $request->montoComision;
            $estadoPago->montoALiquidarPropietario = $request->montoALiquidarPropietario;
            $estadoPago->editadoManual = 1;
            $estadoPago->idEstado = $request->idEstado;
            $estadoPago->fechaLiquidado = $request->fechaLiquidado;
            $estadoPago->save();
            DB::commit();
            //inicio log transaccion
            $nuevoLogTransaccion = new LogTransaccion();
            $nuevoLogTransaccion->tipoTransaccion = 'EDITAR ESTADO PAGO MANDATO: '.$estadoPago->idMandatoPropiedad;
            $nuevoLogTransaccion->idUsuario = Auth::user()->id;
            $nuevoLogTransaccion->webclient = $_SERVER['HTTP_USER_AGENT'];
            $nuevoLogTransaccion->descripcionTransaccion = 'EDITAR ESTADO PAGO MANDATO: '.$estadoPago->idMandatoPropiedad;
            $nuevoLogTransaccion->save();
            //fin log transaccion
            toastr()->success('Estado pago editado con exito');
            return back();
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado');
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
    public function eliminarPagoMandato($id)
    {
        try{
            DB::beginTransaction();
            $estadoPago = EstadosPagosMandatarios::where('idEstadoPagoMandato', '=', $id)->firstOrFail();
            $nuevoLogTransaccion = new LogTransaccion();
            $nuevoLogTransaccion->tipoTransaccion = 'ELIMINAR ESTADO PAGO MANDATO: '.$estadoPago->idMandatoPropiedad;
            $nuevoLogTransaccion->idUsuario = Auth::user()->id;
            $nuevoLogTransaccion->webclient = $_SERVER['HTTP_USER_AGENT'];
            $nuevoLogTransaccion->descripcionTransaccion = 'ELIMINAR ESTADO DE PAGO DE MANTADO : '.$estadoPago->idMandatoPropiedad;
            $nuevoLogTransaccion->save();
            //fin log transaccion
            $estadoPago->delete();
            DB::commit();
            toastr()->success('Liquidacion eliminada con exito');
            return back();
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado');
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
    public function exportLiquidacionInversionista(Request $request)
    {
		try {
            if($request->tipo)
            {
                return Excel::download(new LiquidacionInversionista($request->mes, $request->anio, $request->tipo), 'estadosPagosMandatos.xlsx');
            }
            else
            {
                toastr()->warning('Elija mes, año y estado para generar la planilla Excel');
			    return back();
            }
		} catch (QueryException $e) {
			toastr()->error($e->getMessage());
			return back();
		} catch (ModelNotFoundException $e) {
			toastr()->error('Imagen no encontrada');
			return back();
		} catch (Exception $e) {
			toastr()->error('Se ha producido un error, favor intente nuevamente');
			return back();
		}
	}
    public function imprimirPagoInversionista($id)
    {
        $estadoDePagoFinal = EstadosPagosMandatarios::select('estados_pagos_mandatarios.*', 'users.email as correo', 'users.name as nombre', 'users.apellido', 
        'propiedades.direccion', 'propiedades.numero', 'propiedades.block', 'users.numero as numeroPropietario', 'users.telefono',
        'users.rut as rutPropietario', 'comuna.nombre as nombreComuna', 'region.nombre as nombreRegion', 'planes.comisionAdministracion')
        ->join('estados', 'estados_pagos_mandatarios.idEstado', '=', 'estados.idEstado')
        ->join('mandatos_propiedad', 'estados_pagos_mandatarios.idMandatoPropiedad', '=', 'mandatos_propiedad.idMandatoPropiedad')
        ->join('propiedades', 'mandatos_propiedad.idPropiedad', '=', 'propiedades.id')
        ->join('users', 'mandatos_propiedad.idPropietario', '=', 'users.id')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->join('planes', 'planes.id', '=', 'mandatos_propiedad.idPlan')
        ->where('estados_pagos_mandatarios.idEstadoPagoMandato', '=', $id)
        ->first();
        $cargos = Cargo::where('idEstadoPago', $estadoDePagoFinal->idEstadoPago)
        ->where('correspondeA', 1)
        ->get();
        $descuentos = Descuento::where('idEstadoPago', $estadoDePagoFinal->idEstadoPago)->get();
        $deudas = [];
        $documentos = '';
        $estadoDePagoArrendatario = '';
        $diasNoArrendado = '';
        $mes = '';
        $comisionCorretaje = '';
        $pdf = \PDF::loadView('emails.adjuntoPagoInversionista', [ 'estadoPagoMandato' => $estadoDePagoFinal, 'cargos' => $cargos, 'descuentos' => $descuentos, 'deudas' => $deudas, 'documentos' => $documentos, 'estadoDePagoArrendatario' => $estadoDePagoArrendatario, 'diasNoArrendado' => $diasNoArrendado, 'mes' => $mes, 'comisionCorretaje' => $comisionCorretaje]);
        return $pdf->download();
    }
    public function enviarComprobanteInversionista($id)
    {
        try {
            EnvioPagoInversionista::dispatch($id);
            toastr()->success('Comprobante enviado exitosamente', 'Operacion exitosa');
            //return view('pagos.factura', compact('estadosDePago', 'cargos', 'descuentos', 'totalDescuento', 'totalCargo'));
            return back();
		} catch (QueryException $e) {
			toastr()->error($e->getMessage());
			return back();
		} catch (ModelNotFoundException $e) {
			toastr()->error('Imagen no encontrada');
			return back();
		} catch (Exception $e) {
			toastr()->error('Se ha producido un error, favor intente nuevamente');
			return back();
		}
    }
}
