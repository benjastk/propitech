<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use App\CaracteristicasPorProyectos;
use App\CaracteristicasPropiedades;
use App\TipologiaDepartamento;
use App\NivelUsoPropiedad;
use App\LogTransaccion;
use App\TipoPropiedad;
use App\FotoProyecto;
use App\FotoCercana;
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
        $proyectos = Proyecto::select('proyectos.*', 'tipos_propiedades.nombreTipoPropiedad', 'comuna.nombre as nombreComuna', 'region.nombre as nombreRegion', 
        'estados.nombreEstado')
        ->join('tipos_propiedades', 'tipos_propiedades.idTipoPropiedad', '=', 'proyectos.tipoPropiedad')
        ->join('paises', 'paises.idPais', '=', 'proyectos.idPais')
        ->join('provincia', 'provincia.id', '=', 'proyectos.idProvincia')
        ->join('region', 'region.id', '=', 'proyectos.idRegion')
        ->join('comuna', 'comuna.id', '=', 'proyectos.idComuna')
        ->join('estados', 'estados.idEstado', '=', 'proyectos.idEstado')
        ->get();
        return view('back-office.proyectos.index', compact('user', 'proyectos'));
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
        $caracteristicasPropiedades = CaracteristicasPropiedades::get();
        $expertosVendedores = User::select('users.*')
        ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->where('users.eliminado', 0)
        ->whereIn('rol_usuario.id_rol', [1,2])
        ->get();
        $tipologias = Tipologia::get();
        return view('back-office.proyectos.create', compact('estados', 'user', 'paises', 'regiones', 'provincias', 'comunas', 'nivelesUsoPropiedad', 'tiposPropiedades', 
        'expertosVendedores', 'tipologias', 'caracteristicasPropiedades'));
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
            $proyecto->creadoPor = Auth::user()->id;

            if($request->idDestacado1)
            {
                $proyecto->idDestacado = 1;
            }
            else
            {
                $proyecto->idDestacado = 0;
            }
            if($request->entregaInmediata1)
            {
                $proyecto->entregaInmediata = 1;
            }
            else
            {
                $proyecto->entregaInmediata = 0;
            }

            if($request->hasFile('fotoProyecto')){
                $nombreArchivo = "";
                $file =  $request['fotoProyecto'];
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
        $tipologias = Tipologia::where('idProyecto', $id)->get();
        $caracteristicasPropiedades = CaracteristicasPropiedades::get();
        $caracteristicasProyectos = CaracteristicasPorProyectos::where('idProyecto', $id)->get();
        $expertosVendedores = User::select('users.*')
        ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->where('users.eliminado', 0)
        ->whereIn('rol_usuario.id_rol', [1,2])
        ->get();

        $fotos = FotoProyecto::where('idProyecto', $id)->get();
        $fotosCercanas = FotoCercana::where('idProyecto', $id)->get();
        return view('back-office.proyectos.edit', compact('proyecto', 'user', 'paises', 'regiones', 'provincias', 'comunas', 'nivelesUsoPropiedad', 
        'tiposPropiedades', 'expertosVendedores', 'estados', 'tipologias', 'caracteristicasPropiedades', 'caracteristicasProyectos', 'fotos', 'fotosCercanas'));
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

            if($request->idDestacado1)
            {
                $proyecto->idDestacado = 1;
            }
            else
            {
                $proyecto->idDestacado = 0;
            }
            if($request->entregaInmediata1)
            {
                $proyecto->entregaInmediata = 1;
            }
            else
            {
                $proyecto->entregaInmediata = 0;
            }

            if($request->hasFile('foto')){
                $nombreArchivo = "";
                $file =  $request['foto'];
                $nombreArchivo = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/img/proyecto/', $nombreArchivo);
                $proyecto->fotoProyecto = $nombreArchivo;
            }
            $proyecto->save();

            if($request->comodidades != null) {
                $caracteristicasProyectos = CaracteristicasPorProyectos::where('idProyecto', '=', $id)->get();
                if($caracteristicasProyectos)
                {
                    foreach ($caracteristicasProyectos as $caracteristicaDeLaPropiedad ) {
                        $caracteristicaDeLaPropiedad->delete();
                    }
                }
                foreach ($request->comodidades as $idCaracteristica) {
                    $caracteristicaProyecto = new CaracteristicasPorProyectos;
                    $caracteristicaProyecto->idProyecto = $id;
                    $caracteristicaProyecto->idCaracteristicaPropiedad = $idCaracteristica;
                    $caracteristicaProyecto->save();
                }
            }
            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Actualizacion proyecto';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Actualizacion de proyecto con direccion en: '. $request->direccion. ' numero: '.$request->numero.
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
    public function subirImagen($id, Request $request) 
    {
		try {
			$file = $request->file('file');
		    $path = public_path() . '/img/proyecto/';

		    $proyecto = Proyecto::where('idProyecto', '=', $id)->first();		    
			$img = \Image::make($file);
            // insertando logo a foto subida de la propiedad
			/*$img->insert(public_path() . '/img/logos/otrologo_mini.png', 'center');*/
            // fin isertar marca de agua
		    $fileName = uniqid() . $file->getClientOriginalName();
		    $img->save($path . $fileName);

		    // guardando ruta donde fue almacenada la imagen de la propiedad en la base de datos
		    $foto = new FotoProyecto();
		    $foto->idProyecto = $id;
		    $foto->nombreArchivo = $fileName;
		    $foto->save();

		} catch (QueryException $e) {
			toastr()->warning('Error durante la subida de la(s) imagen(es). Revise que los nombres no tengan espacios ni caracteres invalidos', 'Error');
			return back();
		}
	}
    public function eliminarImagen($id) 
    {
		try {
            if ($id) {
            	$eliminarFoto = FotoProyecto::where('id', '=', $id)->firstOrFail();
                File::delete(public_path('img/proyecto/' . $eliminarFoto->nombreArchivo));
            	$eliminarFoto->delete();
                toastr()->success('Imagen eliminada exitosamente', 'Operación exitosa');
                return back();
            } else {
            	toastr()->warning('Debe indicar un nombre de archivo', 'Advertencia');
            	return back();
            }
		} catch (QueryException $e) {
			toastr()->error('Error de conexion, favor intente nuevamente');
			return back();
		} catch (ModelNotFoundException $e) {
			toastr()->error('Imagen no encontrada');
			return back();
		} catch (Exception $e) {
			toastr()->error('Se ha producido un error, favor intente nuevamente');
			return back();
		}
	}
    public function subirImagenCercana($id, Request $request) 
    {
		try {
			$file = $request->file('file');
		    $path = public_path() . '/img/cercana/';

		    $proyecto = Proyecto::where('idProyecto', '=', $id)->first();		    
			$img = \Image::make($file);
            // insertando logo a foto subida de la propiedad
			/*$img->insert(public_path() . '/img/logos/otrologo_mini.png', 'center');*/
            // fin isertar marca de agua
		    $fileName = uniqid() . $file->getClientOriginalName();
		    $img->save($path . $fileName);

		    // guardando ruta donde fue almacenada la imagen de la propiedad en la base de datos
		    $foto = new FotoCercana();
		    $foto->idProyecto = $id;
		    $foto->nombreArchivo = $fileName;
		    $foto->save();

		} catch (QueryException $e) {
			toastr()->warning('Error durante la subida de la(s) imagen(es). Revise que los nombres no tengan espacios ni caracteres invalidos', 'Error');
			return back();
		}
	}
    public function eliminarImagenCercana($id) 
    {
		try {
            if ($id) {
            	$eliminarFoto = FotoCercana::where('idFotoCercana', '=', $id)->firstOrFail();
                File::delete(public_path('img/cercana/' . $eliminarFoto->nombreArchivo));
            	$eliminarFoto->delete();
                toastr()->success('Imagen eliminada exitosamente', 'Operación exitosa');
                return back();
            } else {
            	toastr()->warning('Debe indicar un nombre de archivo', 'Advertencia');
            	return back();
            }
		} catch (QueryException $e) {
			toastr()->error('Error de conexion, favor intente nuevamente');
			return back();
		} catch (ModelNotFoundException $e) {
			toastr()->error('Imagen no encontrada');
			return back();
		} catch (Exception $e) {
			toastr()->error('Se ha producido un error, favor intente nuevamente');
			return back();
		}
	}
    public function crearTipologia(Request $request)
    {
        try{
            DB::beginTransaction();
            $tipologia = new Tipologia();
            $tipologia->fill($request->all());

            if($request->hasFile('fotoTipologia')){
                $nombreArchivo = "";
                $file =  $request['fotoTipologia'];
                $nombreArchivo = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/img/tipologia/', $nombreArchivo);
                $tipologia->fotoTipologia = $nombreArchivo;
            }
            $tipologia->save();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Nueva Tipologia';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Nueva Tipologia en proyecto: '. $tipologia->idProyecto;
            $logTransaccion->save();
            DB::commit();
            toastr()->success('Tipologia registrada exitosamente', 'Operación exitosa');
            return redirect('/proyectos/edit/'. $tipologia->idProyecto);
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
    public function eliminarTipologia(Request $request)
    {
        try{
            DB::beginTransaction();
            $tipologia = Tipologia::where('idTipologia', $request->idTipologia)->first();
            File::delete(public_path('/img/tipologia/' . $tipologia->fotoTipologia));
            $tipologia->delete();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Eliminar Tipologia';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Eliminar Tipologia en proyecto: '. $tipologia->idProyecto;
            $logTransaccion->save();
            DB::commit();
            toastr()->success('Tipologia registrada exitosamente', 'Operación exitosa');
            return back();
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
