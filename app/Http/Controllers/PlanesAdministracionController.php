<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CaracteristicaPlanAsignada;
use App\PlanAdministracion;
use App\CaracteristicaPlan;
use App\LogTransaccion;
use App\User;
use Session;
use Auth;
use DB;

class PlanesAdministracionController extends Controller
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
        $planes = PlanAdministracion::where('eliminado', 0)->get();
        $caracteristicas = CaracteristicaPlan::get();
        return view('back-office.planes.index', compact('planes', 'user', 'caracteristicas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $caracteristicas = CaracteristicaPlan::orderBy('orden', 'asc')->get();
        return view('back-office.planes.create', compact('caracteristicas', 'user'));
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
            $plan = new PlanAdministracion();
            $plan->fill($request->all());
            if($request->ivaAdministracion)
            {
                $plan->ivaAdministracion = 1;
            }
            else
            {
                $plan->ivaAdministracion = 0;
            }
            if($request->activo)
            {
                $plan->activo = 1;
            }
            else
            {
                $plan->activo = 0;
            }
            if($request->destacado)
            {
                $plan->destacado = 1;
            }
            else
            {
                $plan->destacado = 0;
            }
            if($request->ivaCorretaje)
            {
                $plan->ivaCorretaje = 1;
            }
            else
            {
                $plan->ivaCorretaje = 0;
            }
            $plan->save();
            if($request->options)
            {
                $asignadas = CaracteristicaPlanAsignada::where('idPlan', $plan->id)->get();
                if($asignadas)
                {
                    foreach ($asignadas as $item) 
                    {
                        $item->delete();
                    }
                }
                foreach ($request->options as $key => $value) 
                {
                    $asignadoNuevo = new CaracteristicaPlanAsignada();
                    $asignadoNuevo->idPlan = $plan->id;
                    $asignadoNuevo->idCaracteristicaPlan = $value;
                    $asignadoNuevo->save();
                }
            }

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Nueva plan de administracion';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Nueva plan de administracion nombre: '. $request->nombre. ' Comision Corretaje: '
            .$request->comisionCorretaje.' Comision Administracion: '. $request->comisionAdministracion;
            $logTransaccion->save();
            DB::commit();
            toastr()->success('Plan de administracion agregado exitosamente', 'Operación exitosa');
            return redirect('/planes');
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado', 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage(), 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage(), 'Error');
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
        $plan = PlanAdministracion::where('id', $id)->first();
        $caracteristicas = CaracteristicaPlan::get();
        $asignadas = CaracteristicaPlanAsignada::where('idPlan', $id)->get();
        return view('back-office.planes.edit', compact('caracteristicas', 'plan', 'user', 'asignadas'));
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
            $plan = PlanAdministracion::where('id', $id)->firstOrFail();
            $plan->fill($request->all());
            if($request->ivaAdministracion)
            {
                $plan->ivaAdministracion = 1;
            }
            else
            {
                $plan->ivaAdministracion = 0;
            }
            if($request->destacado)
            {
                $plan->destacado = 1;
            }
            else
            {
                $plan->destacado = 0;
            }
            if($request->ivaCorretaje)
            {
                $plan->ivaCorretaje = 1;
            }
            else
            {
                $plan->ivaCorretaje = 0;
            }
            if($request->activo)
            {
                $plan->activo = 1;
            }
            else
            {
                $plan->activo = 0;
            }
            $plan->save();
            if($request->options)
            {
                $asignadas = CaracteristicaPlanAsignada::where('idPlan', $plan->id)->get();
                if($asignadas)
                {
                    foreach ($asignadas as $item) 
                    {
                        $item->delete();
                    }
                }
                foreach ($request->options as $key => $value) 
                {
                    $asignadoNuevo = new CaracteristicaPlanAsignada();
                    $asignadoNuevo->idPlan = $plan->id;
                    $asignadoNuevo->idCaracteristicaPlan = $value;
                    $asignadoNuevo->save();
                }
            }
            else
            {
                $asignadas = CaracteristicaPlanAsignada::where('idPlan', $plan->id)->get();
                if($asignadas)
                {
                    foreach ($asignadas as $item) 
                    {
                        $item->delete();
                    }
                }
            }

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Actualizacion plan de administracion';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Actualizacion plan de administracion nombre: '. $request->nombre. ' Comision Corretaje: '
            .$request->comisionCorretaje.' Comision Administracion: '. $request->comisionAdministracion;
            $logTransaccion->save();

            DB::commit();
            toastr()->success('Plan de administracion actualizado exitosamente', 'Operación exitosa');
            return redirect('/planes');
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado', 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage(), 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage(), 'Error');
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
            DB::beginTransaction();
            $plan = PlanAdministracion::where('id', $request->id)->first();
            $plan->eliminado = 1;
            $plan->save();
            DB::commit();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Eliminacion plan de administracion';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Eliminacion plan de administracion nombre: '. $plan->nombre. ' Comision Corretaje: '
            .$plan->comisionCorretaje.' Comision Administracion: '. $plan->comisionAdministracion;
            $logTransaccion->save();

            toastr()->success('Plan de administracion eliminado exitosamente', 'Operación exitosa');
            return redirect('/planes');
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado', 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage(), 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage(), 'Error');
            DB::rollback();
            return back()->withInput($request->all());
        }
    }
}
