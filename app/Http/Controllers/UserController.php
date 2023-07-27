<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\UsuarioCuentaBancaria;
use App\TipoCuentaBancaria;
use App\LogTransaccion;
use App\TipoComercial;
use Carbon\Carbon;
use App\Provincia;
use App\UserRol;
use App\Genero;
use App\Comuna;
use App\Region;
use App\Banco;
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
        $users = User::select('users.*', 'roles.nombre', 'roles.id as idRol')
        ->leftjoin('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->leftjoin('roles', 'roles.id', '=', 'rol_usuario.id_rol')
        ->where('users.eliminado', 0)
        ->get();
        $rolUsuario = Auth::user()->rol;
        return view('back-office.usuarios.index', compact('user', 'users', 'rolUsuario'));
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
        return view('back-office.usuarios.create', compact('user', 'paises', 'regiones', 'provincias', 'comunas', 'generos', 'tiposComerciales'));
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

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Creacion de usuario';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Creacion de usuario:'. $request->name. ' '.$request->apellido.
            ' Rut: '. $request->rut. ' Email: '. $request->email. ' Telefono: '. $request->telefono;
            $logTransaccion->save();

            DB::commit();
            toastr()->success('Usuario registrado exitosamente', 'Operación exitosa');
            return redirect('/users');
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
        $usuario = User::where('id', $id)->first();
        $paises = Pais::get();
        $regiones = Region::get();
        $provincias = Provincia::get();
        $comunas = Comuna::get();
        $generos = Genero::get();
        $tiposComerciales = TipoComercial::get();
        return view('back-office.usuarios.edit', compact('usuario', 'user', 'paises', 'regiones', 'provincias', 'comunas', 'generos', 'tiposComerciales'));
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
            $rolUsuario = UserRol::where('id_usuario', $id)->first();
            if($usuario->id != Auth::user()->id && Auth::user()->rol->id_rol == $rolUsuario->id_rol)
            {
                toastr()->error('No puedes cambiar datos de un usuario de tu mismo rol');
                return redirect('/users');
            }
            $usuario->fill($request->all());
            $usuario->password = Hash::make($request->contrasena1);
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
            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Actualizacion de usuario';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Actualizacion de usuario: '. $request->name. ' '.$request->apellido.
            ' Rut: '. $request->rut. ' Email: '. $request->email. ' Telefono: '. $request->telefono;
            $logTransaccion->save();
            DB::commit();
            toastr()->success('Usuario actualizado exitosamente', 'Operación exitosa');
            return redirect('/users');
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

            $usuario = User::where('id', $request->id)->firstOrFail();
            $usuario->eliminado = 1;
            $usuario->save();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Eliminacion de usuario';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Eliminacion de usuario:'. $usuario->name. ' '.$usuario->apellido.
            ' Rut: '. $usuario->rut. ' Email: '. $usuario->email. ' Telefono: '. $usuario->telefono;
            $logTransaccion->save();

            DB::commit();
            toastr()->success('Usuario eliminado exitosamente', 'Operación exitosa');
            return redirect('/users');
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

    public function cuentasBancarias($id)
    {
        $user = Auth::user();
        $bancos = Banco::get();
        $tiposCuentasBancarias = TipoCuentaBancaria::get();
        $cuentasBancarias = UsuarioCuentaBancaria::join('bancos', 'bancos.idBanco', '=', 'usuarios_cuentas_bancarias.idBanco')
        ->join('tipos_cuentas_bancos', 'tipos_cuentas_bancos.idTipoCuenta', '=', 'usuarios_cuentas_bancarias.idTipoCuenta')
        ->where('usuarios_cuentas_bancarias.idUsuario', $id)->get();
        $usuario = User::where('id', $id)->first();
        return view('back-office.usuarios.cuentasBancarias', compact('user', 'cuentasBancarias', 'bancos', 'tiposCuentasBancarias', 'usuario'));
    }
    public function storeCuentaBancaria(Request $request)
    {
        try{
            DB::beginTransaction();
            $usuarioCuentaBancaria = new UsuarioCuentaBancaria();
            $usuarioCuentaBancaria->fill($request->all());
            $usuarioCuentaBancaria->save();

            $usuario = User::where('id', $request->idUsuario)->first();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Nueva Cuenta Bancaria';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Nueva cuenta bancaria en usuario: '. $usuario->name. ' '.$usuario->apellido.
            ' Rut: '. $usuario->rut. ' Numero de cuenta: '. $request->numeroCuenta. ' Banco: '. $request->idBanco;
            $logTransaccion->save();

            DB::commit();
            toastr()->success('Cuenta Bancaria registrada exitosamente', 'Operación exitosa');
            return redirect('/users/cuentas-bancarias/'.$usuario->id);
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
    public function updateCuentaBancaria(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $editarUsuarioCuentaBancaria = UsuarioCuentaBancaria::where('idUsuarioCuentaBancaria', $id)->first();
            $editarUsuarioCuentaBancaria->fill($request->all());
            $editarUsuarioCuentaBancaria->save();

            $usuario = User::where('id', $request->idUsuario)->first();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Actualizacion Cuenta Bancaria';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Actualizacion cuenta bancaria en usuario: '. $usuario->name. ' '.$usuario->apellido.
            ' Rut: '. $usuario->rut. ' Numero de cuenta: '. $request->numeroCuenta. ' Banco: '. $request->idBanco;
            $logTransaccion->save();

            DB::commit();
            toastr()->success('Cuenta Bancaria actualizada exitosamente', 'Operación exitosa');
            return redirect('/users/cuentas-bancarias/'.$usuario->id);
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
    public function deleteCuentaBancaria(Request $request)
    {
        try{
            DB::beginTransaction();
            $deleteUsuarioCuentaBancaria = UsuarioCuentaBancaria::where('idUsuarioCuentaBancaria', $request->id)->first();
            $deleteUsuarioCuentaBancaria->delete();

            $usuario = User::where('id', $deleteUsuarioCuentaBancaria->idUsuario)->first();

            $logTransaccion = new LogTransaccion();
            $logTransaccion->tipoTransaccion = 'Eliminar Cuenta Bancaria';
            $logTransaccion->idUsuario =  Auth::user()->id;
            $logTransaccion->webclient = $request->userAgent();
            $logTransaccion->descripcionTransaccion = 'Eliminar cuenta bancaria en usuario: '. $usuario->name. ' '.$usuario->apellido.
            ' Rut: '. $usuario->rut. ' Numero de cuenta: '. $deleteUsuarioCuentaBancaria->numeroCuenta. ' Banco: '. $deleteUsuarioCuentaBancaria->idBanco;
            $logTransaccion->save();

            DB::commit();
            toastr()->success('Cuenta Bancaria eliminada exitosamente', 'Operación exitosa');
            return redirect('/users/cuentas-bancarias/'.$usuario->id);
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
    public function imprimirDeclaracionJurada(Request $request)
    {
        $usuario = User::select('users.*', 'region.nombre as nombreRegion', 'comuna.nombre as nombreComuna')
        ->join('region', 'region.id', '=', 'users.idRegion')
        ->join('comuna', 'comuna.id', '=', 'users.idComuna')
        ->where('users.id', '=', $request->id)
        ->first();
        $fechaHoy = Carbon::now();
        $pdf = \PDF::loadView('prints.printDeclaracionJurada', compact('usuario', 'fechaHoy'));
        return $pdf->download('Declaracion-Jurada.pdf');
    }
}
