<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comuna;
use App\Region;
use App\Provincia;
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
    public function maps($request) 
    {
        $nuevadireccion = urlencode($request);
        $json = "https://api.mapbox.com/geocoding/v5/mapbox.places/".$nuevadireccion.".json?access_token=pk.eyJ1IjoiYmVuamFzdGsiLCJhIjoiY2xnZHYwZ2V0MG82MjNscnl6dXQxZWxsaiJ9.wLKdL8bv-Y9DKI8qSW_AZw";
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
}
