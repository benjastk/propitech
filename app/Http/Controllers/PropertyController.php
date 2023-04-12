<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NivelUsoPropiedad;
use App\TipoPropiedad;
use App\Propiedad;
use App\Provincia;
use App\Comuna;
use App\Region;
use App\Estado;
use App\Pais;
use App\User;
use Session;
use Auth;
use DB;
class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $propiedades = Propiedad::select('propiedades.*', 'niveles_uso_propiedad.nombreNivelUsoPropiedad', 'tipos_propiedades.nombreTipoPropiedad',
        'paises.nombrePais', 'provincia.nombre as nombreProvincia', 'region.nombre as nombreRegion', 'comuna.nombre as nombreComuna', 'estados.nombreEstado')
        ->join('niveles_uso_propiedad', 'niveles_uso_propiedad.idNivelUsoPropiedad', '=', 'propiedades.idNivelUsoPropiedad')
        ->join('tipos_propiedades', 'tipos_propiedades.idTipoPropiedad', '=', 'propiedades.idTipoPropiedad')
        ->join('paises', 'paises.idPais', '=', 'propiedades.idPais')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('estados', 'estados.idEstado', '=', 'propiedades.idEstado')
        ->paginate(10);
        return view('properties.index', compact('user', 'propiedades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $paises = Pais::get();
        $regiones = Region::get();
        $provincias = Provincia::get();
        $comunas = Comuna::get();
        $nivelesUsoPropiedad = NivelUsoPropiedad::get();
        $tiposPropiedades = TipoPropiedad::get();
        $estados = Estado::where('idTipoEstado', 8)->get();
        $expertosVendedores = User::select('users.*')
        ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->where('users.eliminado', 0)
        ->whereIn('rol_usuario.id_rol', [1,2])
        ->get();
        return view('properties.create', compact('estados', 'user', 'paises', 'regiones', 'provincias', 'comunas', 'nivelesUsoPropiedad', 'tiposPropiedades', 'expertosVendedores'));
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
            $propiedad = new Propiedad();
            $propiedad->fill($request->all());
            $propiedad->idBanco = 1;
            if($request->usoGoceEstacionamiento1)
            {
                $propiedad->usoGoceEstacionamiento = 1;
            }
            else
            {
                $propiedad->usoGoceEstacionamiento = 0;
            }
            if($request->usoGoceBodega1)
            {
                $propiedad->usoGoceBodega = 1;
            }
            else
            {
                $propiedad->usoGoceBodega = 0;
            }
            if($request->mascotas1)
            {
                $propiedad->mascotas = 1;
            }
            else
            {
                $propiedad->mascotas = 0;
            }
            if($request->idDestacado1)
            {
                $propiedad->idDestacado = 1;
            }
            else
            {
                $propiedad->idDestacado = 0;
            }
            if($request->hasFile('foto')){
                $nombreArchivo = "";
                $file =  $request['foto'];
                $nombreArchivo = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/img/propiedad/', $nombreArchivo);
                $propiedad->fotoPrincipal = $nombreArchivo;
            }
            $propiedad->save();
            DB::commit();
            toastr()->success('Propiedad registrada exitosamente');
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
        $propiedad = Propiedad::where('id', $id)->firstOrFail();
        $paises = Pais::get();
        $regiones = Region::get();
        $provincias = Provincia::get();
        $comunas = Comuna::get();
        $nivelesUsoPropiedad = NivelUsoPropiedad::get();
        $tiposPropiedades = TipoPropiedad::get();
        $estados = Estado::where('idTipoEstado', 8)->get();
        $expertosVendedores = User::select('users.*')
        ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->where('users.eliminado', 0)
        ->whereIn('rol_usuario.id_rol', [1,2])
        ->get();
        return view('properties.edit', compact('propiedad', 'user', 'paises', 'regiones', 'provincias', 'comunas', 'nivelesUsoPropiedad', 'tiposPropiedades', 'expertosVendedores', 'estados'));
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
            $propiedad = Propiedad::where('id', $id)->firstOrFail();
            $propiedad->fill($request->all());
            if($request->usoGoceEstacionamiento1)
            {
                $propiedad->usoGoceEstacionamiento = 1;
            }
            else
            {
                $propiedad->usoGoceEstacionamiento = 0;
            }
            if($request->usoGoceBodega1)
            {
                $propiedad->usoGoceBodega = 1;
            }
            else
            {
                $propiedad->usoGoceBodega = 0;
            }
            if($request->mascotas1)
            {
                $propiedad->mascotas = 1;
            }
            else
            {
                $propiedad->mascotas = 0;
            }
            if($request->idDestacado1)
            {
                $propiedad->idDestacado = 1;
            }
            else
            {
                $propiedad->idDestacado = 0;
            }
            if($request->hasFile('foto')){
                $nombreArchivo = "";
                $file =  $request['foto'];
                $nombreArchivo = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/img/propiedad/', $nombreArchivo);
                $propiedad->fotoPrincipal = $nombreArchivo;
            }
            $propiedad->save();

            DB::commit();
            toastr()->success('Propiedad actualizada exitosamente');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        try{
            /*DB::beginTransaction();

            $propiedad = Propiedad::where('id', $request->id)->firstOrFail();
            $propiedad->eliminado = 1;
            $propiedad->save();

            DB::commit();*/
            toastr()->info('Para eliminar se debe suspender la propiedad desde su estado');
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
}
