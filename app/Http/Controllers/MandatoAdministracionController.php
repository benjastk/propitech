<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;
use App\UsuarioCuentaBancaria;
use App\MandatoAdministracion;
use App\PlanAdministracion;
use App\ParametroGeneral;
use App\ContratoArriendo;
use App\LogTransaccion;
use App\Propiedad;
use App\Moneda;
use App\Estado;
use App\User;
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
        ->paginate(10);
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
}
