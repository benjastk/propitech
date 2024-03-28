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
        try{
            DB::beginTransaction();
            $formulario = new FormularioContacto();
            $formulario->fill($request->all());
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
        try{
            DB::beginTransaction();
            $formulario = new FormularioCanje();
            $formulario->fill($request->all());
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
        try{
            DB::beginTransaction();
            $formulario = new FormularioCaptador();
            $formulario->fill($request->all());
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
        try{
            DB::beginTransaction();
            $formulario = new FormularioCaptador();
            $formulario->fill($request->all());
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
        try{
            $renta = RentaMensual::where('idRentaMensual', $request->idRentaMensual)->first();
            DB::beginTransaction();
            $formulario = new FormularioContacto();
            $formulario->fill($request->all());
            if($renta)
            {
                $formulario->mensaje = $request->mensaje. ' - Renta Mensual: '. $renta->nombreRentaMensual;
            }
            else
            {
                $formulario->mensaje = $request->mensaje;
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
