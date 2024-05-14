<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use App\Exports\PropertiesExport;
use App\Http\Controllers\Api\IntegracionYapoController;
use App\CaracteristicasPorPropiedades;
use App\CaracteristicasPropiedades;
use App\NivelUsoPropiedad;
use App\UsuarioPropiedad;
use App\LogTransaccion;
use App\TipoPropiedad;
use App\Propiedad;
use App\Provincia;
use App\Comuna;
use App\Region;
use App\Estado;
use App\Pais;
use App\Foto;
use App\User;
use App\Jobs\AddMarkerImage;
use Session;
use Image;
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
        ->where('propiedades.idEstado', '!=', 46)
        ->get();
        $urlAuthYapo = getenv("YAPO_AUTH_URL");
        $clientID = getenv("YAPO_CLIENT_ID");
        $redirect_url = getenv("YAPO_REDIRECT_URL");
        $urlYapoFinal = $urlAuthYapo.'/authorization?client_id='.$clientID.'&redirect_url='.$redirect_url;
        return view('back-office.properties.index', compact('user', 'propiedades', 'urlYapoFinal'));
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
        $propietarios = User::select('users.*')
        ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->where('users.eliminado', 0)
        ->get();
        $expertosVendedores = User::select('users.*')
        ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->where('users.eliminado', 0)
        ->whereIn('rol_usuario.id_rol', [1,2])
        ->get();
        return view('back-office.properties.create', compact('estados', 'user', 'paises', 'regiones', 'provincias', 'comunas', 'nivelesUsoPropiedad', 'tiposPropiedades', 
        'expertosVendedores', 'caracteristicasPropiedades', 'propietarios'));
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
            $propiedad->descripcion = $request->descripcion;
            $sanitizarTexto = $request->descripcion;
            $sanitizarTexto = str_replace("</p>", "<br>", $sanitizarTexto);
            $sanitizarTexto = str_replace("<br><br>", "<br>", $sanitizarTexto);
            $sanitizarTexto = str_replace("<br><br><br>", "<br>", $sanitizarTexto);
            $sanitizarTexto = strip_tags($sanitizarTexto, '<br>');
            $propiedad->descripcion2 = $sanitizarTexto;
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

                $antiguo = $nombreArchivo;
                $img = \Image::make(public_path('img/propiedad/' . $antiguo));
                /* insert watermark at bottom-right corner with 10px offset */
                $img->insert(public_path('front/logoopacity2.png'), 'center');
                $path = public_path() . '/img/propiedad/';
    
                $fileName = uniqid().'.png';
                $img->save($path . $fileName);
                $propiedad->fotoPrincipal = $fileName;
                $propiedad->marcaDeAgua = 1;
                File::delete(public_path('img/propiedad/' . $antiguo));
            }
            $propiedad->save();
            if($request->comodidades != null) 
            {
                $caracteristicaPropiedad = CaracteristicasPorPropiedades::where('idPropiedad','=', $propiedad->id)->get();
                if($caracteristicaPropiedad)
                {
                    foreach ($caracteristicaPropiedad as $caracteristicaDeLaPropiedad ) {
                        $caracteristicaDeLaPropiedad->delete();
                    }
                }
                foreach ($request->comodidades as $idCaracteristica) {
                    $caracteristicaPropiedad = new CaracteristicasPorPropiedades;
                    $caracteristicaPropiedad->idPropiedad = $propiedad->id;
                    $caracteristicaPropiedad->idCaracteristicaPropiedad = $idCaracteristica;
                    $caracteristicaPropiedad->save();
                }
            }
            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Nueva propiedad';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Nueva propiedad con direccion en: '. $request->direccion. ' numero: '.$request->numero.
            ' Region: '. $request->idRegion. ' Comuna: '. $request->idComuna;
            $logTransaccion->save();
            DB::commit();
            toastr()->success('Propiedad registrada exitosamente', 'Operación exitosa');
            return redirect('/properties');
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
        $propiedad = Propiedad::where('id', $id)->firstOrFail();
        $paises = Pais::get();
        $regiones = Region::get();
        $provincias = Provincia::get();
        $comunas = Comuna::get();
        $nivelesUsoPropiedad = NivelUsoPropiedad::get();
        $tiposPropiedades = TipoPropiedad::get();
        $estados = Estado::where('idTipoEstado', 8)->get();
        $caracteristicasPropiedades = CaracteristicasPropiedades::get();
        $caracteristicaPorPropiedad = CaracteristicasPorPropiedades::where('idPropiedad', $id)->get();
        $usuarioPropietario = UsuarioPropiedad::where('id_propiedad', $id)->first();
        $propietarios = User::select('users.*')
        ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->where('users.eliminado', 0)
        ->get();
        $expertosVendedores = User::select('users.*')
        ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->where('users.eliminado', 0)
        ->whereIn('rol_usuario.id_rol', [1,2])
        ->get();

        $fotos = Foto::where('idPropiedad', $id)->get();
        return view('back-office.properties.edit', compact('propiedad', 'user', 'paises', 'regiones', 'provincias', 'comunas', 'nivelesUsoPropiedad', 
        'tiposPropiedades', 'expertosVendedores', 'estados', 'caracteristicasPropiedades', 'caracteristicaPorPropiedad', 'propietarios', 
        'usuarioPropietario', 'fotos'));
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
            $propiedad->descripcion = $request->descripcion;
            $sanitizarTexto = $request->descripcion;
            $sanitizarTexto = str_replace("</p>", "<br>", $sanitizarTexto);
            $sanitizarTexto = str_replace("<br><br>", "<br>", $sanitizarTexto);
            $sanitizarTexto = str_replace("<br><br><br>", "<br>", $sanitizarTexto);
            $sanitizarTexto = strip_tags($sanitizarTexto, '<br>');
            $propiedad->descripcion2 = $sanitizarTexto;
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

                $antiguo = $nombreArchivo;
                $img = \Image::make(public_path('img/propiedad/' . $antiguo));
                /* insert watermark at bottom-right corner with 10px offset */
                $img->insert(public_path('front/logoopacity2.png'), 'center');
                $path = public_path() . '/img/propiedad/';
    
                $fileName = uniqid().'.png';
                $img->save($path . $fileName);
                $propiedad->fotoPrincipal = $fileName;
                $propiedad->marcaDeAgua = 1;
                File::delete(public_path('img/propiedad/' . $antiguo));
            }
            $propiedad->save();

            if($request->comodidades != null) {
                $caracteristicaPropiedad = CaracteristicasPorPropiedades::where('idPropiedad', '=', $id)->get();
                if($caracteristicaPropiedad)
                {
                    foreach ($caracteristicaPropiedad as $caracteristicaDeLaPropiedad ) {
                        $caracteristicaDeLaPropiedad->delete();
                    }
                }
                foreach ($request->comodidades as $idCaracteristica) {
                    $caracteristicaPropiedad = new CaracteristicasPorPropiedades;
                    $caracteristicaPropiedad->idPropiedad = $id;
                    $caracteristicaPropiedad->idCaracteristicaPropiedad = $idCaracteristica;
                    $caracteristicaPropiedad->save();
                }
            }
            if($request->idUsuarioPropietario)
            {
                $usuarioPropietario = UsuarioPropiedad::where('id_propiedad', $id)->first();
                if($usuarioPropietario)
                {
                    $usuarioPropietario->delete();
                }
                $usuarioPropietarioNew = new UsuarioPropiedad();
                $usuarioPropietarioNew->id_usuario = $request->idUsuarioPropietario;
                $usuarioPropietarioNew->id_propiedad = $id;
                $usuarioPropietarioNew->save();
            }

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Actualizacion propiedad';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Actualizacion de propiedad con direccion en: '. $request->direccion. ' numero: '.$request->numero.
            ' Region: '. $request->idRegion. ' Comuna: '. $request->idComuna;
            $logTransaccion->save();

            $actualizarEnYapo = new IntegracionYapoController();
            $actualizarEnYapo->updateProperties($propiedad->id);
            DB::commit();
            toastr()->success('Propiedad actualizada exitosamente', 'Operación exitosa');
            return redirect('/properties');
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
            toastr()->info('Para eliminar se debe suspender la propiedad desde su estado');
            return redirect('/properties');
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
    // sube imagenes de propiedades
    public function subirImagen($id, Request $request) 
    {
		try {
			$file = $request->file('file');
		    $path = public_path() . '/img/propiedad/';

		    $propiedad = Propiedad::where('id', '=', $id)->first();		    
			$img = \Image::make($file);
            $img->insert(public_path('front/logoopacity2.png'), 'center');
            // insertando logo a foto subida de la propiedad
			/*$img->insert(public_path() . '/img/logos/otrologo_mini.png', 'center');*/
            // fin isertar marca de agua
		    $fileName = uniqid() . $file->getClientOriginalName();
		    $img->save($path . $fileName);

		    // guardando ruta donde fue almacenada la imagen de la propiedad en la base de datos
		    $foto = new Foto();
		    $foto->idPropiedad = $id;
		    $foto->nombreArchivo = $fileName;
            $foto->marcaDeAgua = 1;
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
            	$eliminarFoto = Foto::where('idFoto', '=', $id)->firstOrFail();
                File::delete(public_path('img/propiedad/' . $eliminarFoto->nombreArchivo));
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
    public function exportExcel()
    {
		try {
            return Excel::download(new PropertiesExport, 'propiedades.xlsx');
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
    public function suspendidas()
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
        ->where('propiedades.idEstado', '=', 46)
        ->get();
        return view('back-office.properties.suspendidas', compact('user', 'propiedades'));
    }
    public function destroyCompleto(Request $request)
    {
        try {
            $caracteristicaPropiedad = CaracteristicasPorPropiedades::where('idPropiedad','=', $request->id)->get();
            if($caracteristicaPropiedad)
            {
                foreach ($caracteristicaPropiedad as $caracteristica) 
                {
                    $caracteristica->delete();
                }
            }
            $fotos = Foto::where('idPropiedad', $request->id)->get();
		    if($fotos)
            {
                foreach ($fotos as $foto) 
                {
                    File::delete(public_path('img/propiedad/' . $foto->nombreArchivo));
            	    $foto->delete();
                }
            }
            $propiedad = Propiedad::where('id', $request->id)->first();
            $propiedad->delete();
            toastr()->success('Propiedad eliminada exitosamente', 'Operación exitosa');
            return back();
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
    public function addMarkerFile()
    {
        $fotosGrandes = Foto::where('marcaDeAgua', 0)->get();
        if($fotosGrandes)
        {
            foreach ($fotosGrandes as $foto) 
            {
                $antiguo = $foto->nombreArchivo;
                if(file_exists(('img/propiedad/' . $foto->nombreArchivo))) 
                {
                    $img = \Image::make(public_path('img/propiedad/' . $foto->nombreArchivo));
                    /* insert watermark at bottom-right corner with 10px offset */
                    $img->insert(public_path('front/logoopacity2.png'), 'center');
                    $path = public_path() . '/img/propiedad/';
        
                    $fileName = uniqid().'.png';
                    $img->save($path . $fileName);
                    $foto->nombreArchivo = $fileName;
                    $foto->marcaDeAgua = 1;
                    $foto->save();
                    File::delete(public_path('img/propiedad/' . $antiguo));
                }
            }
        }
        $fotos = Propiedad::whereIn('propiedades.idEstado', [42, 43, 45])
        ->where('marcaDeAgua', 0)->get();
        if($fotos)
        {
            foreach ($fotos as $foto) 
            {
                $antiguo = $foto->fotoPrincipal;
                if(file_exists(('img/propiedad/' . $foto->fotoPrincipal))) 
                {
                    $img = \Image::make(public_path('img/propiedad/' . $foto->fotoPrincipal));
                    /* insert watermark at bottom-right corner with 10px offset */
                    $img->insert(public_path('front/logoopacity2.png'), 'center');
                    $path = public_path() . '/img/propiedad/';
        
                    $fileName = uniqid().'.png';
                    $img->save($path . $fileName);
                    $foto->fotoPrincipal = $fileName;
                    $foto->marcaDeAgua = 1;
                    $foto->save();
                    File::delete(public_path('img/propiedad/' . $antiguo));
                }
            }
        }
    }
    public function duplicarPropiedad(Request $request)
    {
        try {
            $propiedadDuplicada = Propiedad::where('id', $request->id)->first();
            $caracteristicaPropiedad = CaracteristicasPorPropiedades::where('idPropiedad','=', $request->id)->get();
            $fotos = Foto::where('idPropiedad','=', $request->id)->get();
            if($propiedadDuplicada->fotoPrincipal)
            {
                $path = public_path('/img/propiedad/'.$propiedadDuplicada->fotoPrincipal);
                $filename = uniqid().'.png';
                Image::make($path)->save(public_path('img/propiedad/'.$filename));
            }
            $propiedad = new Propiedad();
            $propiedad->idNivelUsoPropiedad = $propiedadDuplicada->idNivelUsoPropiedad;
            $propiedad->idTipoComercial = $propiedadDuplicada->idTipoComercial;
            $propiedad->mostrarTituloAutomatico = $propiedadDuplicada->mostrarTituloAutomatico;
            $propiedad->nombrePropiedad = $propiedadDuplicada->nombrePropiedad;
            $propiedad->rut = $propiedadDuplicada->rut;
            $propiedad->numeroClienteAgua = $propiedadDuplicada->numeroClienteAgua;
            $propiedad->numeroClienteLuz = $propiedadDuplicada->numeroClienteLuz;
            $propiedad->numeroClienteGas = $propiedadDuplicada->numeroClienteGas;
            $propiedad->idTipoPropiedad = $propiedadDuplicada->idTipoPropiedad;
            $propiedad->rolPropiedad = $propiedadDuplicada->rolPropiedad;
            $propiedad->precio = $propiedadDuplicada->precio;
            $propiedad->valorArriendo = $propiedadDuplicada->valorArriendo;
            $propiedad->tasacion = $propiedadDuplicada->tasacion;
            $propiedad->tasacionFinal = $propiedadDuplicada->tasacionFinal;
            $propiedad->gastosComunes = $propiedadDuplicada->gastosComunes;
            $propiedad->contribucion = $propiedadDuplicada->contribucion;
            $propiedad->tieneDeuda = $propiedadDuplicada->tieneDeuda;
            $propiedad->mDeuda = $propiedadDuplicada->mDeuda;
            $propiedad->valorHipoteca = $propiedadDuplicada->valorHipoteca;
            $propiedad->idBanco = $propiedadDuplicada->idBanco;
            $propiedad->banco = $propiedadDuplicada->banco;
            $propiedad->idPais = $propiedadDuplicada->idPais;
            $propiedad->idRegion = $propiedadDuplicada->idRegion;
            $propiedad->idProvincia = $propiedadDuplicada->idProvincia;
            $propiedad->idComuna = $propiedadDuplicada->idComuna;
            $propiedad->direccion = $propiedadDuplicada->direccion;
            $propiedad->numero = $propiedadDuplicada->numero;
            //$propiedad->block = $propiedadDuplicada->block;
            $propiedad->mostrarDireccionExacta = $propiedadDuplicada->mostrarDireccionExacta;
            $propiedad->mTotal = $propiedadDuplicada->mTotal;
            $propiedad->mConstruido = $propiedadDuplicada->mConstruido;
            $propiedad->mTerraza = $propiedadDuplicada->mTerraza;
            $propiedad->bano = $propiedadDuplicada->bano;
            $propiedad->habitacion = $propiedadDuplicada->habitacion;
            $propiedad->numeroPisos = $propiedadDuplicada->numeroPisos;
            $propiedad->latitud = $propiedadDuplicada->latitud;
            $propiedad->longitud = $propiedadDuplicada->longitud;
            $propiedad->POI = $propiedadDuplicada->POI;
            $propiedad->descripcion = $propiedadDuplicada->descripcion;
            $propiedad->descripcion2 = $propiedadDuplicada->descripcion2;
            $propiedad->notaInterna = $propiedadDuplicada->notaInterna;
            $propiedad->idEstado = 91;
            $propiedad->creador = $propiedadDuplicada->creador;
            $propiedad->fecha = $propiedadDuplicada->fecha;
            if($propiedadDuplicada->fotoPrincipal)
            {
                $propiedad->fotoPrincipal = $filename;
            }
            //$propiedad->fotoPrincipalDetalle = $propiedadDuplicada->idNivelUsoPropiedad;
            $propiedad->estacionamiento = $propiedadDuplicada->estacionamiento;
            $propiedad->usoGoceEstacionamiento = $propiedadDuplicada->usoGoceEstacionamiento;
            $propiedad->codigoEstacionamiento = $propiedadDuplicada->codigoEstacionamiento;
            $propiedad->tandem = $propiedadDuplicada->tandem;
            $propiedad->usoGoceTandem = $propiedadDuplicada->usoGoceTandem;
            $propiedad->bodega = $propiedadDuplicada->bodega;
            $propiedad->usoGoceBodega = $propiedadDuplicada->usoGoceBodega;
            $propiedad->codigoBodega = $propiedadDuplicada->codigoBodega;
            $propiedad->score = $propiedadDuplicada->score;
            $propiedad->urlMatterport = $propiedadDuplicada->urlMatterport;
            $propiedad->urlVideo = $propiedadDuplicada->urlVideo;
            $propiedad->idDestacado = $propiedadDuplicada->idDestacado;
            $propiedad->publicarEnTiendaEvento = $propiedadDuplicada->publicarEnTiendaEvento;
            $propiedad->idCorredor = $propiedadDuplicada->idCorredor;
            $propiedad->idUsuarioExpertoVendedor = $propiedadDuplicada->idUsuarioExpertoVendedor;
            $propiedad->idProyecto = $propiedadDuplicada->idProyecto;
            $propiedad->idConDescuento = $propiedadDuplicada->idConDescuento;
            $propiedad->cantidadDescuento = $propiedadDuplicada->cantidadDescuento;
            $propiedad->idConDescuento2 = $propiedadDuplicada->idConDescuento2;
            $propiedad->cantidadDescuento2 = $propiedadDuplicada->cantidadDescuento2;
            $propiedad->codigoEmpresa = $propiedadDuplicada->codigoEmpresa;
            $propiedad->notaEnTienda = $propiedadDuplicada->notaEnTienda;
            $propiedad->contratoConExclusividad = $propiedadDuplicada->contratoConExclusividad;
            $propiedad->idTipoCustodia = $propiedadDuplicada->idTipoCustodia;
            $propiedad->nombreNotariaCustodia = $propiedadDuplicada->nombreNotariaCustodia;
            $propiedad->fechaRecepcionPropiedad = $propiedadDuplicada->fechaRecepcionPropiedad;
            $propiedad->idMoneda = $propiedadDuplicada->idMoneda;
            $propiedad->antiguedad = $propiedadDuplicada->antiguedad;
            $propiedad->idTipoOrientacion = $propiedadDuplicada->idTipoOrientacion;
            $propiedad->mascotas = $propiedadDuplicada->mascotas;
            $propiedad->nombreEdificioComunidad = $propiedadDuplicada->nombreEdificioComunidad;
            $propiedad->orientacion = $propiedadDuplicada->orientacion;
            $propiedad->marcaDeAgua = 1;
            $propiedad->save();
            if($caracteristicaPropiedad) 
            {
                foreach ($caracteristicaPropiedad as $idCaracteristica) 
                {
                    $caracteristicaPropiedad = new CaracteristicasPorPropiedades;
                    $caracteristicaPropiedad->idPropiedad = $propiedad->id;
                    $caracteristicaPropiedad->idCaracteristicaPropiedad = $idCaracteristica->idCaracteristicaPropiedad;
                    $caracteristicaPropiedad->save();
                }
            }
            if($fotos) 
            {
                foreach ($fotos as $fotoOld) 
                {
                    $path = public_path('/img/propiedad/'.$fotoOld->nombreArchivo);
                    $filenameDos = uniqid().'.png';
                    Image::make($path)->save(public_path('img/propiedad/'.$filenameDos));

                    $foto = new Foto();
                    $foto->idPropiedad = $propiedad->id;
                    $foto->nombreArchivo = $filenameDos;
                    $foto->marcaDeAgua = 1;
                    $foto->save();
                }
            }
            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Duplicar propiedad';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Duplicar propiedad con direccion en: '. $propiedad->direccion. ' numero: '.$propiedad->numero.
            ' Region: '. $propiedad->idRegion. ' Comuna: '. $propiedad->idComuna;
            $logTransaccion->save();
            toastr()->success('Propiedad duplicada exitosamente', 'Operación exitosa');
            return back();
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
}
