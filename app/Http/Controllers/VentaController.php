<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;
use App\NumerosEnLetras;
use App\LogTransaccion;
use App\ParametroGeneral;
use App\TipoComercial;
use App\TipoContrato;
use App\Propiedad;
use App\Provincia;
use Carbon\Carbon;
use App\Estado;
use App\Comuna;
use App\Region;
use App\Venta;
use App\Pais;
use App\User;
use Session;
use Auth;
use DB;
class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $entrantes = Venta::select('ventas_propiedades.*', 'users.name', 'users.apellido', 'users.avatarImg')
        ->leftjoin('users', 'users.id', '=', 'ventas_propiedades.idUsuarioVendedor')
        ->where('ventas_propiedades.idEstado', 58)
        ->get();
        $enProgreso = Venta::select('ventas_propiedades.*', 'users.name', 'users.apellido', 'users.avatarImg')
        ->leftjoin('users', 'users.id', '=', 'ventas_propiedades.idUsuarioVendedor')
        ->where('ventas_propiedades.idEstado', 59)
        ->get();
        $finalizadas = Venta::select('ventas_propiedades.*', 'users.name', 'users.apellido', 'users.avatarImg')
        ->leftjoin('users', 'users.id', '=', 'ventas_propiedades.idUsuarioVendedor')
        ->where('ventas_propiedades.idEstado', 60)
        ->get();
        return view ('back-office.ventas.index', compact('user', 'entrantes', 'enProgreso', 'finalizadas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $propiedades = Propiedad::where('idTipoComercial', 1)
        ->where('idEstado', '!=', 46)
        ->get();
        $usuarios = User::select('users.*')
        ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->where('users.eliminado', 0)
        ->whereIn('rol_usuario.id_rol', [1,2])
        ->get();
        $paises = Pais::get();
        $regiones = Region::get();
        $provincias = Provincia::get();
        $comunas = Comuna::get();
        $estados = Estado::where('idTipoEstado', 13)->get();
        return view('back-office.ventas.create', compact('user', 'propiedades', 'usuarios', 'paises', 'regiones', 'provincias', 'comunas', 'estados'));
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
            $nuevaVenta = new Venta();
            $nuevaVenta->fill($request->all());
            $nuevaVenta->save();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Creacion de venta';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Creacion de venta : Valor Venta: '. $request->precioVenta. ' Usuario: '. $request->nombreComprador. ' Apellido: '.
            $request->apellidoComprador. ' Rut: '. $request->rutComprador;
            $logTransaccion->save();
            DB::commit();
            toastr()->success('Venta registrada exitosamente', 'Operación Exitosa');
            return redirect('/ventas');
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
        //
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
        $venta = Venta::where('idVenta', $id)->first();
        $propiedades = Propiedad::where('idTipoComercial', 1)
        ->where('idEstado', '!=', 46)
        ->get();
        $usuarios = User::select('users.*')
        ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->where('users.eliminado', 0)
        ->whereIn('rol_usuario.id_rol', [1,2])
        ->get();
        $paises = Pais::get();
        $regiones = Region::get();
        $provincias = Provincia::get();
        $comunas = Comuna::get();
        $estados = Estado::where('idTipoEstado', 13)->get();
        return view('back-office.ventas.edit', compact('user', 'venta', 'propiedades', 'usuarios', 'paises', 'regiones', 'provincias', 'comunas', 'estados'));
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
            $editarVenta = Venta::where('idVenta', $id)->first();
            $editarVenta->fill($request->all());
            $editarVenta->save();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Edicion de venta';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Edicion de venta : Valor Venta: '. $request->precioVenta. ' Usuario: '. $request->nombreComprador. ' Apellido: '.
            $request->apellidoComprador. ' Rut: '. $request->rutComprador;
            $logTransaccion->save();
            DB::commit();
            toastr()->success('Venta actualizada exitosamente', 'Operación Exitosa');
            return redirect('/ventas');
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
    public function destroy($id)
    {
        //
    }
}
