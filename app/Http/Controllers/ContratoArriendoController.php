<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;
use App\TiempoPagoGarantia;
use App\LogTransaccion;
use App\ParametroGeneral;
use App\ContratoArriendo;
use App\TipoComercial;
use App\TipoContrato;
use App\EstadoPago;
use App\Propiedad;
use App\Provincia;
use Carbon\Carbon;
use App\Estado;
use App\Genero;
use App\Moneda;
use App\Comuna;
use App\Region;
use App\Pais;
use App\User;
use Session;
use Auth;
use DB;
class ContratoArriendoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        $contratosArriendos = ContratoArriendo::select('contratos_arriendos.*', 'estados.nombreEstado', 'propiedades.direccion', 'propiedades.numero', 'propiedades.block')
        ->join('propiedades', 'contratos_arriendos.idPropiedad', '=', 'propiedades.id')
        ->join('estados', 'estados.idEstado', '=', 'contratos_arriendos.idEstado')
        ->get();
        return view('back-office.contratos.index', compact('user', 'contratosArriendos'));
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
        $user = Auth::user();
        $tiposContratos = TipoContrato::get();
        $tiposMonedas = Moneda::get();
        $tiemposPagosGarantias = TiempoPagoGarantia::get();
        $usuarios = User::get();
        $estados = Estado::whereIn('idTipoEstado', [14, 18])->get();
        $reajuste = ParametroGeneral::where('parametroGeneral', '=', 'PORCENTAJE DE AJUSTE ARRIENDO')->first();
        $diaPago = ParametroGeneral::where('parametroGeneral', '=', 'DIA DE PAGO ARRIENDO')->first();
        return view ('back-office.contratos.create', compact('propiedad', 'tiposContratos', 'tiposMonedas', 'tiemposPagosGarantias', 'usuarios', 
        'estados', 'user', 'reajuste', 'diaPago'));
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
            $arrendatario = User::where('rut', '=', $request->rutArrendatario)->first();
            $propietario = User::where('rut', '=', $request->rutPropietario)->first();
            $codeudor = User::where('rut', '=', $request->rutCodeudor)->first();
            $nuevoContrato = new ContratoArriendo();
            $nuevoContrato->fill($request->all());
            $nuevoContrato->idUsuarioArrendatario = $arrendatario->id;
            $nuevoContrato->idUsuarioPropietario = $propietario->id;
            if($request->rutCodeudor != null){
                $nuevoContrato->idUsuarioCodeudor = $codeudor->id;
            }
            $nuevoContrato->idMetodoPago = 1;
            $nuevoContrato->idEstado = 61;
            $nuevoContrato->tokenContratoServicio = Crypt::encrypt($request->rut);
            if($request->reajuste > 0)
            {
                $nuevoContrato->reajuste = $request->reajuste;
                $nuevoContrato->reajustePesos = 0;
            }
            else
            {
                if($request->reajustePesos)
                {
                    $nuevoContrato->reajustePesos = $request->reajustePesos;
                }
                else
                {
                    $nuevoContrato->reajustePesos = 0;
                }
            }
            $nuevoContrato->save();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Nuevo Contrato de arriendo';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Nuevo Contrato de arriendo en propiedad: '. $request->direccionPropiedad. ' - Arrendatario: '.
            $request->nombreArrendatario.' '. $request->apellidoArrendatario;
            $logTransaccion->save();

            $mesYAnio = Carbon::parse($nuevoContrato->desde)->format('Y-m');

            $fechaVencimientoInicial = Carbon::parse($mesYAnio.'-'.$nuevoContrato->diaPago)->format('Y-m-d');
            $reajuste = ParametroGeneral::where('parametroGeneral', '=', 'PORCENTAJE DE AJUSTE ARRIENDO')->first();

            for($i = 1; $i <= $nuevoContrato->tiempoContrato; $i++){
                $nuevosEstadosPagos = new EstadoPago();
                $nuevosEstadosPagos->idContrato = $nuevoContrato->idContratoArriendo;

                if($i > 1)
                {
                    $fechaVencimientoInicial = Carbon::parse($fechaVencimientoInicial)->addMonths(1)->format('Y-m-d');
                    $nuevosEstadosPagos->fechaVencimiento = $fechaVencimientoInicial;
                }
                else
                {
                    $nuevosEstadosPagos->fechaVencimiento = $fechaVencimientoInicial;
                }

                if($i > 6)
                {
                    $nuevosEstadosPagos->arriendoMensual = $nuevoContrato->arriendoMensual + ($nuevoContrato->arriendoMensual * $reajuste->valorParametro) / 100 ;
                    $subtotal = $nuevoContrato->arriendoMensual + ($nuevoContrato->arriendoMensual * $reajuste->valorParametro) / 100 ;
                }
                elseif($i == 1)
                {
                    $nuevosEstadosPagos->comision = (($nuevoContrato->arriendoMensual / 2) * 1.19);
                    $nuevosEstadosPagos->arriendoMensual = $nuevoContrato->arriendoMensual;
                    $subtotal = $nuevoContrato->arriendoMensual + (($nuevoContrato->arriendoMensual / 2) * 1.19);
                }
                else
                {
                    $nuevosEstadosPagos->arriendoMensual = $nuevoContrato->arriendoMensual;
                    $subtotal = $nuevoContrato->arriendoMensual;
                }
                $nuevosEstadosPagos->numeroCuota = $i;
                $nuevosEstadosPagos->idEstado = 47;
                if($nuevoContrato->idTiempoPagoGarantia > 1)
                {
                    $tiempoPagoGarantia = TiempoPagoGarantia::where('idTiempoPagoGarantia', '=', $nuevoContrato->idTiempoPagoGarantia)->first();
                    if($i < $tiempoPagoGarantia->tiempo || $i == $tiempoPagoGarantia->tiempo)
                    {
                        $nuevosEstadosPagos->garantia = ($nuevoContrato->garantia / $tiempoPagoGarantia->tiempo);
                        $subtotal = $subtotal + ($nuevoContrato->garantia / $tiempoPagoGarantia->tiempo);
                    }
                }
                else
                {
                    if($i == 1)
                    {
                        $nuevosEstadosPagos->garantia = $nuevoContrato->garantia;
                        $subtotal = $subtotal + $nuevoContrato->garantia;
                    }
                    else
                    {
                        $nuevosEstadosPagos->garantia = 0;
                        $subtotal = $subtotal + 0;
                    }
                }
                $nuevosEstadosPagos->subtotal = $subtotal;
                $nuevosEstadosPagos->totalPagado = 0; 
                $nuevosEstadosPagos->save();
            }

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Nuevos estados de pagos';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Nuevos estados de pago: '. $request->direccionPropiedad. ' - Arrendatario: '.
            $request->nombreArrendatario.' '. $request->apellidoArrendatario. ' Contrato ID: '.$nuevoContrato->idContratoArriendo ;
            $logTransaccion->save();

            $actualizarPropiedad = Propiedad::where('id', '=', $nuevoContrato->idPropiedad)->firstOrFail();
            $actualizarPropiedad->idEstado = 43;
            $actualizarPropiedad->save();

            DB::commit();
            toastr()->success('Contrato registrado exitosamente');
            /*if($nuevoContrato->idEstado == 2)
            {
                return view('contrato.contratoNuevo', compact('nuevoContrato'));
            }
            else
            {
                return view('contrato.contratoUsado', compact('nuevoContrato'));
            }*/
            return redirect('/properties');
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
        $contratosArriendos = ContratoArriendo::select('contratos_arriendos.idContratoArriendo','propiedades.id', 'propiedades.nombrePropiedad', 'contratos_arriendos.created_at', 
        'contratos_arriendos.nota', 'contratos_arriendos.arriendoMensual', 'contratos_arriendos.nombreArrendatario', 
        'contratos_arriendos.apellidoArrendatario', 'estados.nombreEstado', 'estados.idEstado')
        ->join('propiedades', 'contratos_arriendos.idPropiedad', '=', 'propiedades.id')
        ->join('estados', 'estados.idEstado', '=', 'contratos_arriendos.idEstado')
        ->where('propiedades.id', '=', $id)
        ->get();
        $propiedad = Propiedad::where('id', $id)->first();
        return view ('back-office.contratos.indexForProperties', compact('user', 'contratosArriendos', 'propiedad'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contratoId = $id;
        $contrato = ContratoArriendo::where('idContratoArriendo', '=', $id)->first();
        $tiposContratos = TipoContrato::get();
        $tiposMonedas = Moneda::get();
        $estados = Estado::whereIn('idTipoEstado', [14, 18])->get();
        $tiemposPagosGarantias = TiempoPagoGarantia::get();
        $usuarios = User::get();
        $user = Auth::user();
        $propiedad = Propiedad::select('propiedades.idNivelUsoPropiedad', 'niveles_uso_propiedad.nombreNivelUsoPropiedad')
        ->join('niveles_uso_propiedad', 'propiedades.idNivelUsoPropiedad', '=', 'niveles_uso_propiedad.idNivelUsoPropiedad')
        ->where('propiedades.id', '=', $contrato->idPropiedad)
        ->first();
        $reajuste = ParametroGeneral::where('parametroGeneral', '=', 'PORCENTAJE DE AJUSTE ARRIENDO')->first();
        $diaPago = ParametroGeneral::where('parametroGeneral', '=', 'DIA DE PAGO ARRIENDO')->first();
        return view ('back-office.contratos.edit', compact('contrato', 'contratoId', 'tiposContratos', 'tiposMonedas', 'estados', 'tiemposPagosGarantias', 
        'usuarios', 'user', 'reajuste', 'diaPago', 'propiedad'));
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
            $actualizarContrato = ContratoArriendo::where('idContratoArriendo', '=', $id)->firstOrFail();
            $actualizarContrato->fill($request->all());
            $arrendatario = User::where('rut', '=', $request->rutArrendatario)->first();
            $propietario = User::where('rut', '=', $request->rutPropietario)->first();
            $codeudor = User::where('rut', '=', $request->rutCodeudor)->first();
            $actualizarContrato->idUsuarioArrendatario = $arrendatario->id;
            $actualizarContrato->idUsuarioPropietario = $propietario->id;
            $actualizarContrato->idUsuarioCodeudor = $codeudor->id;
            $actualizarContrato->save();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Actualizacion de Contrato de arriendo';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Actualizacion de Contrato de arriendo en propiedad: '. $actualizarContrato->direccionPropiedad. ' - Arrendatario: '.
            $actualizarContrato->nombreArrendatario.' '. $actualizarContrato->apellidoArrendatario;
            $logTransaccion->save();

            DB::commit();

            toastr()->success('Contrato actualizado exitosamente');
            return redirect('/contratos');
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
            $eliminarContrato = ContratoArriendo::where('idContratoArriendo', '=', $request->id)->first();
            $eliminarContrato->idEstado = 62;
            $eliminarContrato->save();

            $propiedad = Propiedad::where('id', $eliminarContrato->idPropiedad)->first();
            $contratosPropiedad =  ContratoArriendo::where('idPropiedad', '=', $eliminarContrato->idPropiedad)
            ->where('idEstado', 61)
            ->get();
            if($propiedad->idEstado == 43 && count($contratosPropiedad))
            {

            }
            else
            {
                $propiedad->idEstado = 42;
                $propiedad->save();
            }

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Eliminacion de Contrato de arriendo';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Eliminacion de Contrato de arriendo en propiedad: '. $eliminarContrato->direccionPropiedad. ' - Arrendatario: '.
            $eliminarContrato->nombreArrendatario.' '. $eliminarContrato->apellidoArrendatario;
            $logTransaccion->save();

            toastr()->success('Contrato eliminado correctamente');
            DB::commit();
            return redirect('/contratos');
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