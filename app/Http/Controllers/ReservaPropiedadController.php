<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;
use App\ParametroGeneral;
use App\ReservaPropiedad;
use App\NumerosEnLetras;
use App\LogTransaccion;
use App\Propiedad;
use Carbon\Carbon;
use App\Estado;
use App\User;
use Session;
use Auth;
use DB;
class ReservaPropiedadController extends Controller
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
        $reservas = ReservaPropiedad::select('reservas_propiedades.*', 'estados.nombreEstado')
        ->leftjoin('propiedades', 'reservas_propiedades.idPropiedad', '=', 'propiedades.id')
        ->join('estados', 'estados.idEstado', '=', 'reservas_propiedades.idEstado')
        ->get();
        return view('back-office.reservas.index', compact('user', 'reservas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $propiedades = Propiedad::select('propiedades.id', 'rut', 'rolPropiedad', 'nombrePropiedad', 'propiedades.nombrePropiedad', 'propiedades.direccion', 'propiedades.numero', 'region.nombre as nombreRegion', 
        'comuna.nombre as nombreComuna', 'propiedades.idNivelUsoPropiedad', 'niveles_uso_propiedad.nombreNivelUsoPropiedad', 'propiedades.valorArriendo', 'propiedades.block')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('niveles_uso_propiedad', 'propiedades.idNivelUsoPropiedad', '=', 'niveles_uso_propiedad.idNivelUsoPropiedad')
        ->where('propiedades.idEstado', '=', 42)
        ->get();
        $user = Auth::user();
        $estados = Estado::whereIn('idEstado', [47, 48])->get();
        return view ('back-office.reservas.create', compact('propiedades', 'estados', 'user'));
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
            $nuevaReserva = new ReservaPropiedad();
            $nuevaReserva->fill($request->all());
            $nuevaReserva->identificadorUnico = uniqid();
            $nuevaReserva->creadoPor = Auth::user()->name. ' '. Auth::user()->apellido;
            $nuevaReserva->eliminado = 0;
            $nuevaReserva->token = uniqid();
            $nuevaReserva->save();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Creacion de Reserva';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Creacion de reserva : Valor Reserva: '. $request->valorReserva. ' Usuario: '. $request->nombre. ' Apellido: '.
            $request->apellido. ' Rut: '. $request->rut;
            $logTransaccion->save();

            $reservarPropiedad = Propiedad::where('id', $request->idPropiedad)
            ->where('idEstado', 42)
            ->first();
            if($reservarPropiedad)
            {
                $reservarPropiedad->idEstado = 45;
                $reservarPropiedad->save();
            }
            DB::commit();
            toastr()->success('Reserva registrada exitosamente');
            return redirect('/reservas');
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $propiedades = Propiedad::select('propiedades.id', 'rut', 'rolPropiedad', 'nombrePropiedad', 'propiedades.nombrePropiedad', 'propiedades.direccion', 'propiedades.numero', 'region.nombre as nombreRegion', 
        'comuna.nombre as nombreComuna', 'propiedades.idNivelUsoPropiedad', 'niveles_uso_propiedad.nombreNivelUsoPropiedad', 'propiedades.valorArriendo')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('niveles_uso_propiedad', 'propiedades.idNivelUsoPropiedad', '=', 'niveles_uso_propiedad.idNivelUsoPropiedad')
        ->whereIn('propiedades.idEstado', [42, 43, 45])
        ->get();
        $user = Auth::user();
        $estados = Estado::whereIn('idEstado', [47, 48])->get();
        $reserva = ReservaPropiedad::where('idReserva', $id)->first();
        return view ('back-office.reservas.edit', compact('reserva', 'estados', 'propiedades', 'user'));
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
            $actualizarReserva = ReservaPropiedad::where('idReserva', '=', $id)->firstOrFail();
            $actualizarReserva->fill($request->all());
            $actualizarReserva->save();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Actualizacion de Reserva';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Actualizacion de reserva : Valor Reserva: '. $request->valorReserva. ' Usuario: '. $actualizarReserva->nombre. ' Apellido: '.
            $actualizarReserva->apellido. ' Rut: '. $actualizarReserva->rut;
            $logTransaccion->save();

            $reservarPropiedad = Propiedad::where('id', $request->idPropiedad)
            ->where('idEstado', 42)
            ->first();
            if($reservarPropiedad)
            {
                $reservarPropiedad->idEstado = 45;
                $reservarPropiedad->save();
            }
            
            DB::commit();
            toastr()->success('Reserva actualizada exitosamente');
            return redirect('/reservas');
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
            $eliminarReserva = ReservaPropiedad::where('idReserva', '=', $request->id)->firstOrFail();

            $reservarPropiedad = Propiedad::where('id', $eliminarReserva->idPropiedad)
            ->whereIn('idEstado', [45, 43])
            ->first();

            if($reservarPropiedad)
            {
                $reservarPropiedad->idEstado = 42;
                $reservarPropiedad->save();
            }
            $eliminarReserva->eliminado = 1;
            $eliminarReserva->save();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Eliminacion de Reserva';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Eliminacion de Reserva : Valor Reserva: '. $eliminarReserva->valorReserva. ' Usuario: '. $eliminarReserva->nombre. ' Apellido: '.
            $eliminarReserva->apellido. ' Rut: '. $eliminarReserva->rut;
            $logTransaccion->save();
            toastr()->success('Reserva eliminada correctamente');
            DB::commit();
            return redirect('/reservas');
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
