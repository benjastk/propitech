<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use App\Comuna;
use App\User;
use App\Foto;
use App\Region;
use App\Provincia;
use App\Propiedad;
use App\CaracteristicasPorPropiedades;
use App\UsuarioCuentaBancaria;
use App\Mail\AlertaApi as MailFormulario;
use Illuminate\Support\Facades\Mail;
class DataGeneralController extends Controller
{
    public function getRegion(Request $request)
    {
        if ($request->ajax()) {
            return $regiones = Region::where('idPais', $request->id)->get();
        } else {
            return response()->json(['status' => false, 'message' => 'Sin permiso de acceso'], 401);
        }
    }
    public function getProvincia(Request $request)
    {
        if ($request->ajax()) {
            return $provincias = Provincia::where('idRegion', $request->id)->get();
        } else {
            return response()->json(['status' => false, 'message' => 'Sin permiso de acceso'], 401);
        }
    }
    public function getComuna(Request $request)
    {
        if ($request->ajax()) {
            return $comunas = Comuna::where('idProvincia', $request->id)->get();
        } else {
            return response()->json(['status' => false, 'message' => 'Sin permiso de acceso'], 401);
        }
    }
    public function getComunaRegion(Request $request)
    {
        if ($request->ajax()) {
            return $comunas = Comuna::whereIn('idProvincia', Provincia::select('id')->where('idRegion', $request->id)->get())->get();
        } else {
            return response()->json(['status' => false, 'message' => 'Sin permiso de acceso'], 401);
        }
    }
    public function buscarUsuario(Request $request)
    {
        if($request->ajax()){
            $usuario = User::select('users.id', 'users.rut', 'users.numeroSerie', 'users.name', 'users.apellido', 'users.email', 'users.telefono', 'users.nacionalidad', 'users.estadoCivil', 'users.direccion', 'region.nombre as nombreRegion', 'comuna.nombre as nombreComuna')
                        ->join('region', 'region.id', '=', 'users.idRegion')
                        ->join('comuna', 'comuna.id', '=', 'users.idComuna')
                        ->where('users.rut', '=', $request->all())
                        ->first();
            return $usuario;
        }else{
            return response()->json(['status' => false, 'message' => 'Sin permiso de acceso'], 401);
        }
    }
    public function buscarUsuarioPropietario(Request $request)
    {
        if($request->ajax()){
            $usuario = User::select('users.id', 'users.rut', 'users.numeroSerie', 'users.name', 'users.apellido', 'users.email', 'users.telefono', 
            'users.nacionalidad', 'users.estadoCivil', 'users.direccion', 'users.profesion', 'users.numero', 'region.nombre as nombreRegion', 
            'comuna.nombre as nombreComuna')
            ->leftjoin('region', 'region.id', '=', 'users.idRegion')
            ->leftjoin('comuna', 'comuna.id', '=', 'users.idComuna')
            ->where('users.rut', '=', $request->all())
            ->first();
            $usuario->cuentas = UsuarioCuentaBancaria::where('idUsuario', '=', $usuario->id)
            ->join('bancos', 'bancos.idbanco', '=', 'usuarios_cuentas_bancarias.idBanco')
            ->join('tipos_cuentas_bancos', 'usuarios_cuentas_bancarias.idTipoCuenta', '=', 'tipos_cuentas_bancos.idTipoCuenta')
            ->get();
            return $usuario;
        }else{
            return response()->json(['status' => false, 'message' => 'Sin permiso de acceso'], 401);
        }
    }
    public function getPropiedad(Request $request)
    {
        if($request->ajax()){
            $propiedad = Propiedad::select('propiedades.id', 'rut', 'rolPropiedad', 'nombrePropiedad', 'propiedades.nombrePropiedad', 'propiedades.direccion', 'propiedades.numero', 'region.nombre as nombreRegion', 
            'comuna.nombre as nombreComuna', 'propiedades.idNivelUsoPropiedad', 'niveles_uso_propiedad.nombreNivelUsoPropiedad', 'propiedades.valorArriendo', 'propiedades.block',
            'propiedades.idPais', 'propiedades.idRegion', 'propiedades.idProvincia', 'propiedades.idComuna')
            ->join('region', 'region.id', '=', 'propiedades.idRegion')
            ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
            ->join('niveles_uso_propiedad', 'propiedades.idNivelUsoPropiedad', '=', 'niveles_uso_propiedad.idNivelUsoPropiedad')
            ->where('propiedades.id', '=', $request->id)
            ->first();
            return $propiedad;
        }else{
            return response()->json(['status' => false, 'message' => 'Sin permiso de acceso'], 401);
        }
    }
    public function maps($request) 
    {
        $nuevadireccion = urlencode($request);
        $json = "https://maps.googleapis.com/maps/api/geocode/json?address={$nuevadireccion}&key=AIzaSyAzyDN_wIGU_xsKCYm-0L7pF54cuR2sq5I";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $jsonfile = file_get_contents($json);
        $google_maps = json_decode($jsonfile);
        return response()->json($google_maps);
    }
    public function spam() 
    {
        $json = "http://www.usenix.org.uk/content/rblremove";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $jsonfile = file_get_contents($json);
        $spam = json_decode($jsonfile);
        return response()->json($response);
    }
    public function allPropertiesForPropit()
    {
        try
        {
            $propiedades = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
            'region.nombre as nombreRegion', 'tipos_propiedades.nombreTipoPropiedad', 'niveles_uso_propiedad.nombreNivelUsoPropiedad', 'users.name',
            'users.email', 'users.telefono')
            ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
            ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
            ->join('region', 'region.id', '=', 'propiedades.idRegion')
            ->join('tipos_propiedades', 'propiedades.idTipoPropiedad', '=', 'tipos_propiedades.idTipoPropiedad')
            ->join('niveles_uso_propiedad', 'propiedades.idNivelUsoPropiedad', '=', 'niveles_uso_propiedad.idNivelUsoPropiedad')
            ->leftjoin('users', 'users.id', '=', 'propiedades.idUsuarioExpertoVendedor')
            ->where('propiedades.idEstado', 42)
            ->where('descripcion', "!=", "")
            ->get();
            if($propiedades)
            {
                foreach ($propiedades as $propiedad) 
                {
                    $fotos = Foto::where('idPropiedad', $propiedad->id)->get();
                    if($fotos)
                    {
                        $propiedad->fotos = $fotos;
                    }
                    else
                    {
                        $propiedad->fotos = [];
                    }
                }
                foreach ($propiedades as $propiedad2) 
                {
                    $amenidades = CaracteristicasPorPropiedades::select('caracteristicas_propiedades.*')
                    ->join('propiedades', 'propiedades.id', '=', 'caracteristicas_por_propiedades.idPropiedad')
                    ->join('caracteristicas_propiedades', 'caracteristicas_propiedades.idCaracteristicaPropiedad', '=', 'caracteristicas_por_propiedades.idCaracteristicaPropiedad')
                    ->where('caracteristicas_por_propiedades.idPropiedad', $propiedad2->id)
                    ->get();
                    if($amenidades)
                    {
                        $propiedad->amenidades = $amenidades;
                    }
                    else
                    {
                        $propiedad->amenidades = [];
                    }
                }
            }
            return response()->view('xmlTemplate', compact('propiedades'))->header('Content-Type', 'text/xml');
        } catch (QueryException $e) {
            Mail::to(['beenjaahp@hotmail.com',
                'beenjaahp@gmail.com'])
            ->send(new MailAlertaApi());
            return false;
        } catch (ModelNotFoundException $e) {
            Mail::to(['beenjaahp@hotmail.com',
                'beenjaahp@gmail.com'])
            ->send(new MailAlertaApi());
            return false;
        } catch (Exception $e) {
            /*Mail::to(['beenjaahp@hotmail.com',
                'beenjaahp@gmail.com'])
            ->send(new MailAlertaApi());*/
            return false;
        }
    }
    public function allPropertiesForYapo()
    {
        try
        {
            $propiedades = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
            'region.nombre as nombreRegion', 'tipos_propiedades.nombreTipoPropiedad', 'niveles_uso_propiedad.nombreNivelUsoPropiedad', 'users.name',
            'users.email', 'users.telefono')
            ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
            ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
            ->join('region', 'region.id', '=', 'propiedades.idRegion')
            ->join('tipos_propiedades', 'propiedades.idTipoPropiedad', '=', 'tipos_propiedades.idTipoPropiedad')
            ->join('niveles_uso_propiedad', 'propiedades.idNivelUsoPropiedad', '=', 'niveles_uso_propiedad.idNivelUsoPropiedad')
            ->leftjoin('users', 'users.id', '=', 'propiedades.idUsuarioExpertoVendedor')
            ->where('propiedades.idEstado', 42)
            ->where('descripcion', "!=", "")
            ->limit(5)
            ->get();
            if($propiedades)
            {
                foreach ($propiedades as $propiedad) 
                {
                    $fotos = Foto::where('idPropiedad', $propiedad->id)->get();
                    if($fotos)
                    {
                        $propiedad->fotos = $fotos;
                    }
                    else
                    {
                        $propiedad->fotos = [];
                    }
                }
                foreach ($propiedades as $propiedad2) 
                {
                    $amenidades = CaracteristicasPorPropiedades::select('caracteristicas_propiedades.*')
                    ->join('propiedades', 'propiedades.id', '=', 'caracteristicas_por_propiedades.idPropiedad')
                    ->join('caracteristicas_propiedades', 'caracteristicas_propiedades.idCaracteristicaPropiedad', '=', 'caracteristicas_por_propiedades.idCaracteristicaPropiedad')
                    ->where('caracteristicas_por_propiedades.idPropiedad', $propiedad2->id)
                    ->get();
                    if($amenidades)
                    {
                        $propiedad->amenidades = $amenidades;
                    }
                    else
                    {
                        $propiedad->amenidades = [];
                    }
                }
            }
            return response()->view('xmlTemplateYapo', compact('propiedades'))->header('Content-Type', 'text/xml');
        } catch (QueryException $e) {
            Mail::to(['beenjaahp@hotmail.com',
                'beenjaahp@gmail.com'])
            ->send(new MailAlertaApi());
            return false;
        } catch (ModelNotFoundException $e) {
            Mail::to(['beenjaahp@hotmail.com',
                'beenjaahp@gmail.com'])
            ->send(new MailAlertaApi());
            return false;
        } catch (Exception $e) {
            /*Mail::to(['beenjaahp@hotmail.com',
                'beenjaahp@gmail.com'])
            ->send(new MailAlertaApi());*/
            return false;
        }
    }
}
