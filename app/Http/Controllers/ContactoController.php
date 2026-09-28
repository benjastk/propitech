<?php

namespace App\Http\Controllers;
use App\Mail\FormularioContacto as MailFormulario;
use App\Mail\FormularioCanje as MailFormularioCanje;
use App\Mail\FormularioCaptador as MailFormularioCaptador;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\RentaMensual;
use App\FormularioCaptador;
use App\FormularioContacto;
use App\FormularioCanje;
use Session;
use DB;
class ContactoController extends Controller
{
    public function contactoController(Request $request)
    {
        $datos = $request->validate([
            'id_formulario' => 'nullable|integer',
            'nombre' => 'required|string|max:150',
            'telefono' => 'required|string|max:30|regex:/^[0-9 ()+\-]+$/',
            'email' => 'required|email|max:150',
            'mensaje' => 'nullable|string|max:2000',
        ]);
        $datos['nombre'] = strip_tags($datos['nombre']);
        if(isset($datos['mensaje'])) {
            $datos['mensaje'] = strip_tags($datos['mensaje']);
        }
        try{
            DB::beginTransaction();
            $formulario = new FormularioContacto();
            $formulario->fill($datos);
            $formulario->save();
            
            $formularioDos = FormularioContacto::select('formulario_contacto.*', 'tipo_formulario.nombreFormulario')
            ->leftjoin('tipo_formulario', 'tipo_formulario.id', '=', 'formulario_contacto.id_formulario')
            ->where('formulario_contacto.id', $formulario->id)
            ->first();
            
            Mail::to(['beenjaahp@hotmail.com','admin@benjaminperez.cl'])
            ->send(new MailFormulario($formularioDos));
            DB::commit();
            toastr()->success('Formulario enviado exitosamente, pronto lo contactaremos.', 'Operación exitosa');
            return redirect('/');
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado', 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage(), 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado', 'Información');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage(), 'Error');
            DB::rollback();
            return back()->withInput($request->all());
        }
    }
    public function formularioCanje(Request $request)
    {
        $datos = $request->validate([
            'nombreCorredor' => 'required|string|max:150',
            'emailCorredor' => 'required|email|max:150',
            'telefonoCorredor' => 'required|string|max:30|regex:/^[0-9 ()+\-]+$/',
            'cantidadPropiedades' => 'required|integer|min:0',
            'tipoOperacion' => 'required|integer',
            'ciudadCorredor' => 'required|string|max:150',
        ]);
        $datos['nombreCorredor'] = strip_tags($datos['nombreCorredor']);
        $datos['ciudadCorredor'] = strip_tags($datos['ciudadCorredor']);
        try{
            DB::beginTransaction();
            $formulario = new FormularioCanje();
            $formulario->fill($datos);
            $formulario->save();
            
            $formularioDos = FormularioCanje::select('formulario_canjes.*', 'tipos_comerciales.nombreTipoComercial')
            ->leftjoin('tipos_comerciales', 'tipos_comerciales.idTipoComercial', '=', 'formulario_canjes.tipoOperacion')
            ->where('formulario_canjes.id', $formulario->id)
            ->first();
            
            Mail::to(['beenjaahp@hotmail.com','admin@benjaminperez.cl'])
            ->send(new MailFormularioCanje($formularioDos));
            DB::commit();
            toastr()->success('Formulario enviado exitosamente, pronto lo contactaremos.', 'Operación exitosa');
            return redirect('/');
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado', 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage(), 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado', 'Información');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage(), 'Error');
            DB::rollback();
            return back()->withInput($request->all());
        }
    }
    public function formularioCaptador(Request $request)
    {
        $datos = $request->validate([
            'nombrePropietario' => 'required|string|max:150',
            'correoPropietario' => 'required|email|max:150',
            'telefonoPropietario' => 'required|string|max:30|regex:/^[0-9 ()+\-]+$/',
            'diaVisita' => 'nullable|string|max:150',
            'direccionPropiedad' => 'required|string|max:255',
            'tipoOperacion' => 'required|integer',
            'tipoPropiedad' => 'required|integer',
            'dormitorios' => 'required|integer',
            'banos' => 'required|integer',
            'estacionamiento' => 'required|boolean',
            'bodega' => 'required|boolean',
            'nombreCaptador' => 'required|string|max:150',
            'rutCaptador' => 'required|string|max:20|regex:/^[0-9kK.\-]+$/',
            'telefonoCaptador' => 'required|string|max:30|regex:/^[0-9 ()+\-]+$/',
        ]);
        foreach(['nombrePropietario', 'diaVisita', 'direccionPropiedad', 'nombreCaptador'] as $campo) {
            if(isset($datos[$campo])) {
                $datos[$campo] = strip_tags($datos[$campo]);
            }
        }
        try{
            DB::beginTransaction();
            $formulario = new FormularioCaptador();
            $formulario->fill($datos);
            $formulario->save();
            
            $formularioDos = FormularioCaptador::select('formulario_captador.*', 'tipos_comerciales.nombreTipoComercial', 'tipos_propiedades.nombreTipoPropiedad')
            ->leftjoin('tipos_comerciales', 'tipos_comerciales.idTipoComercial', '=', 'formulario_captador.tipoOperacion')
            ->leftjoin('tipos_propiedades', 'tipos_propiedades.idTipoPropiedad', '=', 'formulario_captador.tipoPropiedad')
            ->where('formulario_captador.id', $formulario->id)
            ->first();
            
            Mail::to(['beenjaahp@hotmail.com','admin@benjaminperez.cl'])
            ->send(new MailFormularioCaptador($formularioDos));
            DB::commit();
            toastr()->success('Formulario enviado exitosamente, pronto lo contactaremos.', 'Operación exitosa');
            return redirect('/');
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado', 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage(), 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado', 'Información');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage(), 'Error');
            DB::rollback();
            return back()->withInput($request->all());
        }
    }
    public function formularioPublicaTuPropiedad(Request $request)
    {
        $datos = $request->validate([
            'nombrePropietario' => 'required|string|max:150',
            'correoPropietario' => 'required|email|max:150',
            'telefonoPropietario' => 'required|string|max:30|regex:/^[0-9 ()+\-]+$/',
            'direccionPropiedad' => 'required|string|max:255',
            'tipoOperacion' => 'required|integer',
            'tipoPropiedad' => 'nullable|integer',
            'mensaje' => 'nullable|string|max:2000',
        ]);
        foreach(['nombrePropietario', 'direccionPropiedad', 'mensaje'] as $campo) {
            if(isset($datos[$campo])) {
                $datos[$campo] = strip_tags($datos[$campo]);
            }
        }
        try{
            DB::beginTransaction();
            $formulario = new FormularioCaptador();
            $formulario->fill($datos);
            $formulario->isCaptador = 0;
            $formulario->save();
            
            $formularioDos = FormularioCaptador::select('formulario_captador.*', 'tipos_comerciales.nombreTipoComercial', 'tipos_propiedades.nombreTipoPropiedad')
            ->leftjoin('tipos_comerciales', 'tipos_comerciales.idTipoComercial', '=', 'formulario_captador.tipoOperacion')
            ->leftjoin('tipos_propiedades', 'tipos_propiedades.idTipoPropiedad', '=', 'formulario_captador.tipoPropiedad')
            ->where('formulario_captador.id', $formulario->id)
            ->first();
            
            Mail::to(['beenjaahp@hotmail.com',
                'beenjaahp@gmail.com'])
            ->send(new MailFormularioCaptador($formularioDos));
            DB::commit();
            toastr()->success('Formulario enviado exitosamente, pronto lo contactaremos.', 'Operación exitosa');
            return redirect('/publica-tu-propiedad');
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado', 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage(), 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado', 'Información');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage(), 'Error');
            DB::rollback();
            return back()->withInput($request->all());
        }
    }
    public function formularioInversiones(Request $request)
    {
        $datos = $request->validate([
            'id_formulario' => 'nullable|integer',
            'nombre' => 'required|string|max:150',
            'telefono' => 'required|string|max:30|regex:/^[0-9 ()+\-]+$/',
            'email' => 'required|email|max:150',
            'mensaje' => 'nullable|string|max:2000',
            'idRentaMensual' => 'nullable|integer',
        ]);
        $datos['nombre'] = strip_tags($datos['nombre']);
        $mensaje = isset($datos['mensaje']) ? strip_tags($datos['mensaje']) : null;
        try{
            $renta = isset($datos['idRentaMensual']) ? RentaMensual::where('idRentaMensual', $datos['idRentaMensual'])->first() : null;
            DB::beginTransaction();
            $formulario = new FormularioContacto();
            $formulario->fill($datos);
            if($renta)
            {
                $formulario->mensaje = $mensaje. ' - Renta Mensual: '. $renta->nombreRentaMensual;
            }
            else
            {
                $formulario->mensaje = $mensaje;
            }
            $formulario->save();
            
            $formularioDos = FormularioContacto::select('formulario_contacto.*', 'tipo_formulario.nombreFormulario')
            ->leftjoin('tipo_formulario', 'tipo_formulario.id', '=', 'formulario_contacto.id_formulario')
            ->where('formulario_contacto.id', $formulario->id)
            ->first();
            
            Mail::to(['beenjaahp@hotmail.com','admin@benjaminperez.cl'])
            ->send(new MailFormulario($formularioDos));
            DB::commit();
            toastr()->success('Formulario enviado exitosamente, pronto lo contactaremos.', 'Operación exitosa');
            return redirect('/proyectos-venta');
        } catch (ModelNotFoundException $e) {
            toastr()->warning('No autorizado', 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (QueryException $e) {
            toastr()->warning('Ha ocurrido un error, favor intente nuevamente' . $e->getMessage(), 'Advertencia');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (DecryptException $e) {
            toastr()->info('Ocurrio un error al intentar acceder al recurso solicitado', 'Información');
            DB::rollback();
            return back()->withInput($request->all());
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage(), 'Error');
            DB::rollback();
            return back()->withInput($request->all());
        }
    }
}
