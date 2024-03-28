<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ParametroGeneral;
use App\LogTransaccion;
use App\User;
use Session;
use Auth;
use DB;
class ParametrosGeneralesController extends Controller
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
        $parametrosGenerales = ParametroGeneral::get();
        $usuarios = User::select('users.id', 'users.rut', 'users.numeroSerie', 'users.name', 'users.apellido', 'users.email', 'users.telefono', 
        'users.nacionalidad', 'users.estadoCivil', 'users.direccion', 'users.profesion', 'users.numero', 'region.nombre as nombreRegion', 
        'comuna.nombre as nombreComuna')
        ->leftjoin('region', 'region.id', '=', 'users.idRegion')
        ->leftjoin('comuna', 'comuna.id', '=', 'users.idComuna')
        ->get();
        return view('back-office.parametros.index', compact('user', 'parametrosGenerales', 'usuarios'));
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
        //
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
        $parametroGeneral = ParametroGeneral::where('idParametroGeneral', $id)->first();
        return view('back-office.parametros.edit', compact('user', 'parametroGeneral'));
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
            $parametroGeneral = ParametroGeneral::where('idParametroGeneral', '=', $id)->firstOrFail();
            $valorAnterior = $parametroGeneral->valorParametro;
            $parametroGeneral->fill($request->all());
            $parametroGeneral->save();
            DB::commit();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Actualizacion de parametro general';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Actualizacion de parametro general: '.$parametroGeneral->parametroGeneral.
            ' - Valor Anterior: '.$valorAnterior. ' Nuevo Valor: '. $request->valorParametro;
            $logTransaccion->save();

            toastr()->success('Parametro actualizado exitosamente');
            return redirect('/parametros');
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
