<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\LogTransaccion;
use App\Noticia;
use App\User;
use Session;
use Auth;
use DB;
class NoticiaController extends Controller
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
        $noticias = Noticia::select('noticias.*', 'users.*', 'roles.nombre')
        ->leftjoin('users', 'noticias.idUsuario', '=', 'users.id')
        ->leftjoin('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->leftjoin('roles', 'roles.id', '=', 'rol_usuario.id_rol')
        ->get();
        return view('back-office.noticias.index', compact('noticias', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $users = User::select('users.*', 'roles.nombre')
        ->leftjoin('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->leftjoin('roles', 'roles.id', '=', 'rol_usuario.id_rol')
        ->where('users.eliminado', 0)
        ->get();
        return view('back-office.noticias.create', compact('users', 'user'));
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
            $noticia = new Noticia();
            $noticia->fill($request->all());
            $noticia->fechaPublicacion = date('Y-m-d');
            $slug = Str::slug($request->titulo);
            $noticia->urlNoticia = $slug;
            if($request->hasFile('foto'))
            {
                $nombreArchivo = "";
                $file =  $request['foto'];
                $nombreArchivo = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/img/noticias/', $nombreArchivo);
                $noticia->imagenNoticia = $nombreArchivo;
            }
            $noticia->save();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Nueva publicacion en blog';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Nueva publicacion en blog con titulo: '.$request->titulo;
            $logTransaccion->save();

            DB::commit();
            toastr()->success('Noticia agregada exitosamente', 'Operación exitosa');
            return redirect('/noticias');
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
        $users = User::select('users.*', 'roles.nombre')
        ->leftjoin('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->leftjoin('roles', 'roles.id', '=', 'rol_usuario.id_rol')
        ->where('users.eliminado', 0)
        ->get();
        $noticia = Noticia::where('idNoticia', $id)->first();
        return view('back-office.noticias.edit', compact('users', 'noticia', 'user'));
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
            $noticia = Noticia::where('idNoticia', $id)->firstOrFail();
            if($noticia->urlNoticia)
            {

            }
            else
            {
                $slug = Str::slug($request->titulo);
                $noticia->urlNoticia = $slug;
            }
            $noticia->fill($request->all());
            if($noticia->fechaPublicacion)
            {

            }
            else
            {
                $noticia->fechaPublicacion = date('Y-m-d');
            }
            if($request->hasFile('foto')){
                $nombreArchivo = "";
                $file =  $request['foto'];
                $nombreArchivo = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/img/noticias/', $nombreArchivo);
                $noticia->imagenNoticia = $nombreArchivo;
            }
            $noticia->save();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Actualizacion de publicacion en blog';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Actualizacion de publicacion en blog con titulo: '.$noticia->titulo;
            $logTransaccion->save();

            DB::commit();
            toastr()->success('Noticia actualizada exitosamente', 'Operación exitosa');
            return redirect('/noticias');
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
            $noticia = Noticia::where('idNoticia', $request->id)->first();
            $noticia->deleteOf = 1;
            $noticia->save();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Eliminacion de publicacion en blog';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Eliminacion de publicacion en blog con titulo: '.$noticia->titulo;
            $logTransaccion->save();

            DB::commit();
            toastr()->success('Noticia eliminada exitosamente', 'Operación exitosa');
            return redirect('/noticias');
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
