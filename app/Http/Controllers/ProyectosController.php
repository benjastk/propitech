<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use App\TipologiaDepartamento;
use App\NivelUsoPropiedad;
use App\LogTransaccion;
use App\TipoPropiedad;
use App\Tipologia;
use App\Provincia;
use App\Proyecto;
use App\Comuna;
use App\Region;
use App\Estado;
use App\Pais;
use App\Foto;
use App\User;
use Session;
use Image;
use Auth;
use DB;

class ProyectosController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $propiedades = Proyecto::join('tipos_propiedades', 'tipos_propiedades.idTipoPropiedad', '=', 'propiedades.idTipoPropiedad')
        ->join('paises', 'paises.idPais', '=', 'propiedades.idPais')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('estados', 'estados.idEstado', '=', 'propiedades.idEstado')
        ->get();
        return view('back-office.proyectos.index', compact('user', 'propiedades'));
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
        $tipologias = Tipologia::get();
        return view('back-office.proyectos.create', compact('estados', 'user', 'paises', 'regiones', 'provincias', 'comunas', 'nivelesUsoPropiedad', 'tiposPropiedades', 
        'expertosVendedores', 'tipologias'));
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
            $proyecto = new Proyecto();
            $proyecto->fill($request->all());
            $proyecto->descripcion = $request->descripcion;
            $sanitizarTexto = $request->descripcion;
            $sanitizarTexto = str_replace("</p>", "<br>", $sanitizarTexto);
            $sanitizarTexto = str_replace("<br><br>", "<br>", $sanitizarTexto);
            $sanitizarTexto = str_replace("<br><br><br>", "<br>", $sanitizarTexto);
            $sanitizarTexto = strip_tags($sanitizarTexto, '<br>');
            $proyecto->descripcion2 = $sanitizarTexto;
        
            if($request->hasFile('foto')){
                $nombreArchivo = "";
                $file =  $request['foto'];
                $nombreArchivo = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/img/proyecto/', $nombreArchivo);
                $proyecto->fotoProyecto = $nombreArchivo;
            }
            $proyecto->save();
            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Nuevo Proyecto de Inversion';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Nuevo Proyecto con direccion en: '. $request->direccion. ' numero: '.$request->numero.
            ' Region: '. $request->idRegion. ' Comuna: '. $request->idComuna;
            $logTransaccion->save();
            DB::commit();
            toastr()->success('Proyecto registrado exitosamente', 'Operación exitosa');
            return redirect('/proyectos');
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
        $proyecto = Proyecto::where('idProyecto', $id)->firstOrFail();
        $paises = Pais::get();
        $regiones = Region::get();
        $provincias = Provincia::get();
        $comunas = Comuna::get();
        $nivelesUsoPropiedad = NivelUsoPropiedad::get();
        $tiposPropiedades = TipoPropiedad::get();
        $estados = Estado::where('idTipoEstado', 8)->get();
        $tipologias = Tipologia::get();
        $expertosVendedores = User::select('users.*')
        ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->where('users.eliminado', 0)
        ->whereIn('rol_usuario.id_rol', [1,2])
        ->get();

        $fotos = Foto::where('idPropiedad', $id)->get();
        return view('back-office.proyectos.edit', compact('proyecto', 'user', 'paises', 'regiones', 'provincias', 'comunas', 'nivelesUsoPropiedad', 
        'tiposPropiedades', 'expertosVendedores', 'estados', 'fotos', 'tipologias'));
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
            $proyecto = Proyecto::where('idProyecto', $id)->firstOrFail();
            $proyecto->fill($request->all());
            $proyecto->descripcion = $request->descripcion;
            $sanitizarTexto = $request->descripcion;
            $sanitizarTexto = str_replace("</p>", "<br>", $sanitizarTexto);
            $sanitizarTexto = str_replace("<br><br>", "<br>", $sanitizarTexto);
            $sanitizarTexto = str_replace("<br><br><br>", "<br>", $sanitizarTexto);
            $sanitizarTexto = strip_tags($sanitizarTexto, '<br>');
            $proyecto->descripcion2 = $sanitizarTexto;

            if($request->hasFile('foto')){
                $nombreArchivo = "";
                $file =  $request['foto'];
                $nombreArchivo = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/img/proyecto/', $nombreArchivo);
                $proyecto->fotoProyecto = $nombreArchivo;
            }
            $proyecto->save();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Actualizacion propiedad';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Actualizacion de propiedad con direccion en: '. $request->direccion. ' numero: '.$request->numero.
            ' Region: '. $request->idRegion. ' Comuna: '. $request->idComuna;
            $logTransaccion->save();

            DB::commit();
            toastr()->success('Proyecto actualizado exitosamente', 'Operación exitosa');
            return redirect('/proyectos');
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
            return $e->getMessage();
            DB::rollback();
            return back()->withInput($request->all(), 'Error');
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
            toastr()->info('Para eliminar se debe suspender el proyecto desde su estado');
            return redirect('/proyectos');
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
