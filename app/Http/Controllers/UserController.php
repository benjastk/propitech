<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\TipoComercial;
use App\Provincia;
use App\UserRol;
use App\Genero;
use App\Comuna;
use App\Region;
use App\Pais;
use App\User;
use Session;
use Auth;
use DB;
class UserController extends Controller
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
        $users = User::select('users.*', 'roles.nombre')
        ->leftjoin('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->leftjoin('roles', 'roles.id', '=', 'rol_usuario.id_rol')
        ->where('users.eliminado', 0)
        ->paginate(15);
        return view('usuarios.index', compact('user', 'users'));
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
        $generos = Genero::get();
        $tiposComerciales = TipoComercial::get();
        return view('usuarios.create', compact('user', 'paises', 'regiones', 'provincias', 'comunas', 'generos', 'tiposComerciales'));
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
            if ($request->contrasena1 != $request->contrasena2) {
                toastr()->error('Contraseña no coincide');
                return redirect()->back()->withInput();
            }
            DB::beginTransaction();

            $usuario = new User();
            $usuario->fill($request->all());
            $usuario->password = Hash::make($request->contrasena1);
            $usuario->tokenCorto = uniqid();
            $usuario->creadoPor = Auth::user()->rut;
            $usuario->idTipoUsuario = 2;

            if($request->hasFile('foto')){
                $nombreArchivo = "";
                $file =  $request['foto'];
                $nombreArchivo = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/img/usuarios/', $nombreArchivo);
                $usuario->avatarImg = $nombreArchivo;
            }
            $usuario->save();

            DB::commit();
            toastr()->success('Usuario registrado exitosamente');
            return redirect('/users');
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
        $usuario = User::where('id', $id)->first();
        $paises = Pais::get();
        $regiones = Region::get();
        $provincias = Provincia::get();
        $comunas = Comuna::get();
        $generos = Genero::get();
        $tiposComerciales = TipoComercial::get();
        return view('usuarios.edit', compact('usuario', 'user', 'paises', 'regiones', 'provincias', 'comunas', 'generos', 'tiposComerciales'));
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

            $usuario = User::where('id', $id)->firstOrFail();
            $usuario->fill($request->all());
            if($request->hasFile('foto')){
                $nombreArchivo = "";
                $file =  $request['foto'];
                $nombreArchivo = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/img/usuarios/', $nombreArchivo);
                $usuario->avatarImg = $nombreArchivo;
            }
            $usuario->save();

            $usuarioRol = UserRol::where('id_usuario', $id)->first();
            if(!$usuarioRol)
            {
                $usuarioRol = new UserRol();
                $usuarioRol->id_usuario = $id;
                $usuarioRol->id_rol = 3;
                $usuarioRol->save();
            }
            DB::commit();
            toastr()->success('Usuario actualizado exitosamente');
            return redirect('/users');
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
        try{
            DB::beginTransaction();

            $usuario = User::where('id', $request->id)->firstOrFail();
            $usuario->eliminado = 1;
            $usuario->save();

            DB::commit();
            toastr()->success('Usuario eliminado exitosamente');
            return redirect('/users');
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
