<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MantencionPropiedad;
use App\NivelUsoPropiedad;
use App\LogTransaccion;
use App\TipoPropiedad;
use App\Propiedad;
use App\Estado;
use App\User;
use Session;
use Image;
use Auth;
use DB;
class MantencionPropiedadController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/
    public function index()
    {
        $user = Auth::user();
        $propiedades = Propiedad::select('propiedades.*', 'niveles_uso_propiedad.nombreNivelUsoPropiedad', 'tipos_propiedades.nombreTipoPropiedad',
        'paises.nombrePais', 'provincia.nombre as nombreProvincia', 'region.nombre as nombreRegion', 'comuna.nombre as nombreComuna', 'estados.nombreEstado',
        'mantenciones_propiedades.mantencion_termo', 'mantenciones_propiedades.mantencion_encimera', 'mantenciones_propiedades.mantencion_calefont')
        ->join('niveles_uso_propiedad', 'niveles_uso_propiedad.idNivelUsoPropiedad', '=', 'propiedades.idNivelUsoPropiedad')
        ->join('tipos_propiedades', 'tipos_propiedades.idTipoPropiedad', '=', 'propiedades.idTipoPropiedad')
        ->join('paises', 'paises.idPais', '=', 'propiedades.idPais')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('estados', 'estados.idEstado', '=', 'propiedades.idEstado')
        ->leftjoin('mantenciones_propiedades', 'propiedades.id', '=', 'mantenciones_propiedades.id_propiedad')
        ->where('propiedades.idEstado', '!=', 46)
        ->where('propiedades.idTipoComercial', 2)
        ->get();
        $contador = Propiedad::where('idEstado', '!=', 46)
        ->where('idTipoComercial', 2)
        ->count();
        return view('back-office.mantenciones.index', compact('user', 'propiedades', 'contador'));
    }
    public function save(Request $request)
    {
        try {
            $mantencion = MantencionPropiedad::where(
                'id_propiedad',
                $request->property_id
            )->first();

            if (!$mantencion) {
                $mantencion = new MantencionPropiedad();
                $mantencion->id_propiedad = $request->property_id;
            }

            $propiedad = Propiedad::where('id', $request->property_id)->first();

            $mantencion->direccion = $propiedad->direccion;
            $mantencion->numero = $propiedad->numero;
            $mantencion->block = $propiedad->block;
            $mantencion->mantencion_termo = $request->fecha1 ?: null;
            $mantencion->mantencion_encimera = $request->fecha2 ?: null;
            $mantencion->mantencion_calefont = $request->fecha3 ?: null;
            $mantencion->user_id = Auth::id();
            $mantencion->save();

            return response()->json([
                'success' => true,
                'message' => 'Mantenciones guardadas correctamente'
            ]);
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
