<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Jobs\IntegrarYapoCL;
use App\Propiedad;
use App\Foto;
use App\User;
use Auth;
use Log;

class IntegracionYapoController extends Controller
{
    public function auth()
    {
        $urlAuthYapo = getenv("YAPO_AUTH_URL");
        $clientID = getenv("YAPO_CLIENT_ID");
        $redirect_url = getenv("YAPO_REDIRECT_URL");
        return redirect()->to($urlAuthYapo.'/authorization?client_id='.$clientID.'&redirect_url='.$redirect_url);
    }
    public function getToken(Request $request)
    {
        try
        {
            $urlAuthYapo = getenv("YAPO_AUTH_URL");
            $clientID = getenv("YAPO_CLIENT_ID");
            $redirect_url = getenv("YAPO_REDIRECT_URL");
            $secretClient = getenv("YAPO_SECRET_CLIENT");
            $yapoApiUrl = getenv("YAPO_API_URL");
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $yapoApiUrl.'-auth/auth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "clientID": "'.$clientID.'",
                "clientSecret": "'.$secretClient.'",
                "code": "'.$request->code.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $responseDos = json_decode($response, true);
            $user = User::where('id', Auth::user()->id)->first();
            if($user)
            {
                $user->tokenYapo = $responseDos['accessToken'];
                $user->tiempoSesion = $responseDos['ttl'];
                $user->refreshTokenYapo = $responseDos['refreshToken'];
                $user->save();
            }
            toastr()->success('Sesion inicidada correctamente en Yapo.cl', 'Operacion exitosa');
            return redirect('/properties');
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function refreshToken()
    {
        try
        {
            $users = User::select('users.*', 'roles.nombre', 'roles.id as idRol')
            ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'rol_usuario.id_rol')
            ->whereIn('rol_usuario.id_rol', [1, 2])
            ->get();
            $tokenRefreshYapo = $users[0]->refreshTokenYapo;
            $urlAuthYapo = getenv("YAPO_AUTH_URL");
            $clientID = getenv("YAPO_CLIENT_ID");
            $redirect_url = getenv("YAPO_REDIRECT_URL");
            $secretClient = getenv("YAPO_SECRET_CLIENT");
            $yapoApiUrl = getenv("YAPO_API_URL");
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $yapoApiUrl.'-auth/auth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "clientID": "'.$clientID.'",
                "clientSecret": "'.$secretClient.'",
                "refreshToken": "'.$tokenRefreshYapo.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $responseDos = json_decode($response, true);
            if($users)
            {
                foreach ($users as $user) 
                {
                    $user->tokenYapo = $responseDos['accessToken'];
                    $user->tiempoSesion = $responseDos['ttl'];
                    $user->refreshTokenYapo = $responseDos['refreshToken'];
                    $user->save();
                }
            }
            return true;
        } catch (\Exception $e) {
            Log::info('Info', array('error' => $e->getMessage()));
            return false;
        }
    }
    public function listAds()
    {
        try
        {
            $users = User::select('users.*', 'roles.nombre', 'roles.id as idRol')
            ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'rol_usuario.id_rol')
            ->whereIn('rol_usuario.id_rol', [1, 2])
            ->get();
            $tokenYapo = $users[0]->tokenYapo;
            
            $urlAuthYapo = getenv("YAPO_AUTH_URL");
            $clientID = getenv("YAPO_CLIENT_ID");
            $redirect_url = getenv("YAPO_REDIRECT_URL");
            $secretClient = getenv("YAPO_SECRET_CLIENT");
            $yapoApiUrl = getenv("YAPO_API_URL");
            $keyName = getenv("YAPO_API_KEYNAME");

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $yapoApiUrl.'/ads/list?keyName='.$keyName.'&pageSize=50&pageNumber=1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$tokenYapo
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $responseDos = json_decode($response, true);
            return response()->json($responseDos);
        } catch (\Exception $e) {
            Log::info('Info', array('error' => $e->getMessage()));
            return false;
        }
    }
    public function storeProperties($id)
    {
        try {
            $clientID = getenv("YAPO_CLIENT_ID");
            $propiedad = Propiedad::select('propiedades.*', 'niveles_uso_propiedad.nombreNivelUsoPropiedad', 'tipos_propiedades.nombreTipoPropiedad',
            'paises.nombrePais', 'provincia.nombre as nombreProvincia', 'region.nombre as nombreRegion', 'comuna.nombre as nombreComuna', 'estados.nombreEstado')
            ->join('niveles_uso_propiedad', 'niveles_uso_propiedad.idNivelUsoPropiedad', '=', 'propiedades.idNivelUsoPropiedad')
            ->join('tipos_propiedades', 'tipos_propiedades.idTipoPropiedad', '=', 'propiedades.idTipoPropiedad')
            ->join('paises', 'paises.idPais', '=', 'propiedades.idPais')
            ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
            ->join('region', 'region.id', '=', 'propiedades.idRegion')
            ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
            ->join('estados', 'estados.idEstado', '=', 'propiedades.idEstado')
            ->where('propiedades.idEstado', '!=', 46)
            ->where('propiedades.id', '=', $id)
            ->first();
            if($propiedad)
            {
                $fotos = Foto::where('idPropiedad', $id)->limit(20)->get();
                $fotosFinales = array();
                if($fotos)
                {
                    foreach ($fotos as $foto) 
                    {
                        $url = 'https://propitech.cl/img/propiedad/'. $foto->nombreArchivo.'"';
                        array_push($fotosFinales, $url);
                    }
                    $fotosAPublicar = implode(", ", $fotosFinales);
                }
                if($propiedad->idTipoComercial == 1)
                {
                    $tipoOperacion = 'venta';
                    $moneda = 'uf';
                    $precio = $propiedad->precio;
                }
                else
                {
                    $tipoOperacion = 'arriendo';
                    $moneda = 'peso';
                    $precio = $propiedad->valorArriendo;
                }
                if($propiedad->idTipoPropiedad == 1)
                {
                    $tipoPropiedad = 'casa';
                }
                elseif($propiedad->idTipoPropiedad == 2)
                {
                    $tipoPropiedad = 'departamento';
                }
                elseif($propiedad->idTipoPropiedad == 3)
                {
                    $tipoPropiedad = 'sitio';
                }
                elseif($propiedad->idTipoPropiedad == 4)
                {
                    $tipoPropiedad = '';
                }
                elseif($propiedad->idTipoPropiedad == 5)
                {
                    $tipoPropiedad = 'parcela';
                }
                elseif($propiedad->idTipoPropiedad == 6)
                {
                    $tipoPropiedad = '';
                }
                elseif($propiedad->idTipoPropiedad == 7)
                {
                    $tipoPropiedad = 'house';
                }
                elseif($propiedad->idTipoPropiedad == 8)
                {
                    $tipoPropiedad = 'oficina';
                }
                elseif($propiedad->idTipoPropiedad == 9)
                {
                    $tipoPropiedad = 'departamento';
                }
                elseif($propiedad->idTipoPropiedad == 10)
                {
                    $tipoPropiedad = 'local';
                }
                $fotosss = json_encode($fotosFinales);
                $descripcion = json_encode($propiedad->descripcion2, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                if($propiedad->usoGoceEstacionamiento > 0)
                {
                    $request = '{"ad": {
                            "externalID": "'.$propiedad->id.'",
                            "category": "'.$tipoOperacion.'",
                            "subCategory": "'.$tipoPropiedad.'",
                            "description": '.$descripcion.',
                            "attributes": {
                                "rooms": "'.$propiedad->habitacion.'",
                                "bathrooms": "'.$propiedad->bano.'",
                                "parkingLots": "'.$propiedad->usoGoceEstacionamiento.'",
                                "size": "'.$propiedad->mConstruido.'",
                                "utilSize": "'.$propiedad->mTotal.'"
                            },
                            "location": {
                                "address": "'.$propiedad->direccion.' '.$propiedad->numero.'",
                                "commune": "'.$propiedad->nombreComuna.'",
                                "geoposition": "'.$propiedad->latitud.','.$propiedad->longitud.'"
                            },
                            "price": "'.$precio.'",
                            "currency": "'.$moneda.'",
                            "externalAgentID": "'.$clientID.'",
                            "title": "'.$propiedad->nombrePropiedad.'",
                            "images":'.$fotosss.'
                        }
                    }';
                }   
                else
                {   
                    $request = '{"ad": {
                            "externalID": "'.$propiedad->id.'",
                            "category": "'.$tipoOperacion.'",
                            "subCategory": "'.$tipoPropiedad.'",
                            "description": '.$descripcion.',
                            "attributes": {
                                "rooms": "'.$propiedad->habitacion.'",
                                "bathrooms": "'.$propiedad->bano.'",
                                "size": "'.$propiedad->mConstruido.'",
                                "utilSize": "'.$propiedad->mTotal.'"
                            },
                            "location": {
                                "address": "'.$propiedad->direccion.' '.$propiedad->numero.'",
                                "commune": "'.$propiedad->nombreComuna.'",
                                "geoposition": "'.$propiedad->latitud.','.$propiedad->longitud.'"
                            },
                            "price": "'.$precio.'",
                            "currency": "'.$moneda.'",
                            "externalAgentID": "'.$clientID.'",
                            "title": "'.$propiedad->nombrePropiedad.'",
                            "images":'.$fotosss.'
                        }
                    }';
                }
                
                $users = User::select('users.*', 'roles.nombre', 'roles.id as idRol')
                ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'rol_usuario.id_rol')
                ->whereIn('rol_usuario.id_rol', [1, 2])
                ->get();
                $tokenYapo = $users[0]->tokenYapo;
                $clientID = getenv("YAPO_CLIENT_ID");
                $secretClient = getenv("YAPO_SECRET_CLIENT");
                $yapoApiUrl = getenv("YAPO_API_URL");
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $yapoApiUrl.'/ads',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $request,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$tokenYapo
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $responseDos = json_decode($response, true);
                Log::info('Status', array('body' => $responseDos));
                if($responseDos['status'] == 200)
                {
                    $propiedad = Propiedad::where('id', $id)->first();
                    $propiedad->urlYapo = $responseDos['ad']['url'];
                    $propiedad->internalIDYapo = $responseDos['ad']['internalID'];
                    $propiedad->listIDYapo = $responseDos['ad']['listID'];
                    $propiedad->externalIDYapo = $responseDos['ad']['externalID'];
                    $propiedad->save();
                    toastr()->success('Subida completada a Yapo.cl', 'Operación Exitosa');
                    return back();
                }
                else
                {
                    toastr()->error('Tenemos un problema al subir la publicacion', 'Algo Falló');
                    return back();
                }
            }
        } catch (\Exception $e) {
            Log::info('error', array('body' => $e->getMessage()));
            toastr()->error('Tenemos un problema al subir la publicacion', 'Algo Falló');
            return back();
        }
    }
    public function updateProperties($id)
    {
        try {
            $clientID = getenv("YAPO_CLIENT_ID");
            $propiedad = Propiedad::select('propiedades.*', 'niveles_uso_propiedad.nombreNivelUsoPropiedad', 'tipos_propiedades.nombreTipoPropiedad',
            'paises.nombrePais', 'provincia.nombre as nombreProvincia', 'region.nombre as nombreRegion', 'comuna.nombre as nombreComuna', 'estados.nombreEstado')
            ->join('niveles_uso_propiedad', 'niveles_uso_propiedad.idNivelUsoPropiedad', '=', 'propiedades.idNivelUsoPropiedad')
            ->join('tipos_propiedades', 'tipos_propiedades.idTipoPropiedad', '=', 'propiedades.idTipoPropiedad')
            ->join('paises', 'paises.idPais', '=', 'propiedades.idPais')
            ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
            ->join('region', 'region.id', '=', 'propiedades.idRegion')
            ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
            ->join('estados', 'estados.idEstado', '=', 'propiedades.idEstado')
            ->where('propiedades.idEstado', '!=', 46)
            ->where('propiedades.id', '=', $id)
            ->first();
            if($propiedad)
            {
                $fotos = Foto::where('idPropiedad', $id)->limit(20)->get();
                $fotosFinales = array();
                $fotosAPublicar = '';
                if($fotos)
                {
                    foreach ($fotos as $foto) 
                    {
                        $url = 'https://propitech.cl/img/propiedad/'. $foto->nombreArchivo;
                        array_push($fotosFinales, $url);
                    }
                }
                if($propiedad->idTipoComercial == 1)
                {
                    $tipoOperacion = 'venta';
                    $moneda = 'uf';
                    $precio = $propiedad->precio;
                }
                else
                {
                    $tipoOperacion = 'arriendo';
                    $moneda = 'peso';
                    $precio = $propiedad->valorArriendo;
                }
                if($propiedad->idTipoPropiedad == 1)
                {
                    $tipoPropiedad = 'casa';
                }
                elseif($propiedad->idTipoPropiedad == 2)
                {
                    $tipoPropiedad = 'departamento';
                }
                elseif($propiedad->idTipoPropiedad == 3)
                {
                    $tipoPropiedad = 'sitio';
                }
                elseif($propiedad->idTipoPropiedad == 4)
                {
                    $tipoPropiedad = '';
                }
                elseif($propiedad->idTipoPropiedad == 5)
                {
                    $tipoPropiedad = 'parcela';
                }
                elseif($propiedad->idTipoPropiedad == 6)
                {
                    $tipoPropiedad = '';
                }
                elseif($propiedad->idTipoPropiedad == 7)
                {
                    $tipoPropiedad = 'house';
                }
                elseif($propiedad->idTipoPropiedad == 8)
                {
                    $tipoPropiedad = 'oficina';
                }
                elseif($propiedad->idTipoPropiedad == 9)
                {
                    $tipoPropiedad = 'departamento';
                }
                elseif($propiedad->idTipoPropiedad == 10)
                {
                    $tipoPropiedad = 'local';
                }
                $fotosss = json_encode($fotosFinales);
                $descripcion = json_encode($propiedad->descripcion2, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                if($propiedad->usoGoceEstacionamiento > 0)
                {
                    $request = '{"ad": {
                            "externalID": "'.$propiedad->id.'",
                            "category": "'.$tipoOperacion.'",
                            "subCategory": "'.$tipoPropiedad.'",
                            "description": '.$descripcion.',
                            "attributes": {
                                "rooms": "'.$propiedad->habitacion.'",
                                "bathrooms": "'.$propiedad->bano.'",
                                "parkingLots": "'.$propiedad->usoGoceEstacionamiento.'",
                                "size": "'.$propiedad->mConstruido.'",
                                "utilSize": "'.$propiedad->mTotal.'"
                            },
                            "location": {
                                "address": "'.$propiedad->direccion.' '.$propiedad->numero.'",
                                "commune": "'.$propiedad->nombreComuna.'",
                                "geoposition": "'.$propiedad->latitud.','.$propiedad->longitud.'"
                            },
                            "price": "'.$precio.'",
                            "currency": "'.$moneda.'",
                            "externalAgentID": "'.$clientID.'",
                            "title": "'.$propiedad->nombrePropiedad.'",
                            "images":'.$fotosss.'
                        }
                    }';
                }   
                else
                {   
                    $request = '{"ad": {
                            "externalID": "'.$propiedad->id.'",
                            "category": "'.$tipoOperacion.'",
                            "subCategory": "'.$tipoPropiedad.'",
                            "description": '.$descripcion.',
                            "attributes": {
                                "rooms": "'.$propiedad->habitacion.'",
                                "bathrooms": "'.$propiedad->bano.'",
                                "size": "'.$propiedad->mConstruido.'",
                                "utilSize": "'.$propiedad->mTotal.'"
                            },
                            "location": {
                                "address": "'.$propiedad->direccion.' '.$propiedad->numero.'",
                                "commune": "'.$propiedad->nombreComuna.'",
                                "geoposition": "'.$propiedad->latitud.','.$propiedad->longitud.'"
                            },
                            "price": "'.$precio.'",
                            "currency": "'.$moneda.'",
                            "externalAgentID": "'.$clientID.'",
                            "title": "'.$propiedad->nombrePropiedad.'",
                            "images":'.$fotosss.'            
                        }
                    }';
                }
                
                $users = User::select('users.*', 'roles.nombre', 'roles.id as idRol')
                ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'rol_usuario.id_rol')
                ->whereIn('rol_usuario.id_rol', [1, 2])
                ->get();
                $tokenYapo = $users[0]->tokenYapo;
                $clientID = getenv("YAPO_CLIENT_ID");
                $secretClient = getenv("YAPO_SECRET_CLIENT");
                $yapoApiUrl = getenv("YAPO_API_URL");
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $yapoApiUrl.'/ads',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_POSTFIELDS => $request,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$tokenYapo
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $responseDos = json_decode($response, true);
                
                if($responseDos['status'] == 200)
                {
                    $propiedad = Propiedad::where('id', $id)->first();
                    $propiedad->urlYapo = $responseDos['ad']['url'];
                    $propiedad->internalIDYapo = $responseDos['ad']['internalID'];
                    $propiedad->listIDYapo = $responseDos['ad']['listID'];
                    $propiedad->externalIDYapo = $responseDos['ad']['externalID'];
                    $propiedad->save();
                    return response()->json($responseDos);
                }
                else
                {
                    return response()->json($responseDos);
                }
            }
        } catch (\Exception $e) {
            Log::info('error', array('body' => $e->getMessage()));
            return response()->json($e->getMessage());
        }
    }
    public function deleteProperties($id)
    {
        try {
            $clientID = getenv("YAPO_CLIENT_ID");
            $propiedad = Propiedad::where('id', '=', $id)
            ->first();
            if($propiedad)
            {                
                $users = User::select('users.*', 'roles.nombre', 'roles.id as idRol')
                ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'rol_usuario.id_rol')
                ->whereIn('rol_usuario.id_rol', [1, 2])
                ->get();
                $tokenYapo = $users[0]->tokenYapo;
                $clientID = getenv("YAPO_CLIENT_ID");
                $secretClient = getenv("YAPO_SECRET_CLIENT");
                $yapoApiUrl = getenv("YAPO_API_URL");
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $yapoApiUrl.'/ads',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'DELETE',
                CURLOPT_POSTFIELDS =>'{
                    "externalID": "'.$propiedad->id.'"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$tokenYapo
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $responseDos = json_decode($response, true);
                
                if($responseDos['status'] == 200)
                {
                    $propiedad = Propiedad::where('id', $id)->first();
                    $propiedad->urlYapo = null;
                    $propiedad->internalIDYapo = null;
                    $propiedad->listIDYapo = null;
                    $propiedad->externalIDYapo = null;
                    $propiedad->save();
                    toastr()->success('Eliminada completamente de Yapo.cl', 'Operación Exitosa');
                    return back();
                }
                else
                {
                    toastr()->error($responseDos, 'Algo Falló');
                    return back();
                }
            }
        } catch (\Exception $e) {
            Log::info('error', array('body' => $e->getMessage()));
            toastr()->error('Tenemos un problema al subir la publicacion'. $e->getMessage(), 'Algo Falló');
            return back();
        }
    }
    public function integracionMasivaYapoCL()
    {
        try {
            IntegrarYapoCL::dispatch();
            Log::info('success', array('body' => 'listo'));
        } catch (\Exception $e) {
            Log::info('error', array('body' => $e->getMessage()));
        }
    }
    public function prueba()
    {
        $clientID = getenv("YAPO_CLIENT_ID");
        $propiedades = Propiedad::select('propiedades.*', 'niveles_uso_propiedad.nombreNivelUsoPropiedad', 'tipos_propiedades.nombreTipoPropiedad',
        'paises.nombrePais', 'provincia.nombre as nombreProvincia', 'region.nombre as nombreRegion', 'comuna.nombre as nombreComuna', 'estados.nombreEstado')
        ->join('niveles_uso_propiedad', 'niveles_uso_propiedad.idNivelUsoPropiedad', '=', 'propiedades.idNivelUsoPropiedad')
        ->join('tipos_propiedades', 'tipos_propiedades.idTipoPropiedad', '=', 'propiedades.idTipoPropiedad')
        ->join('paises', 'paises.idPais', '=', 'propiedades.idPais')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('estados', 'estados.idEstado', '=', 'propiedades.idEstado')
        ->where('propiedades.idEstado', '=', 42)
        ->whereNull('urlYapo')
        ->get();
        $propiedadessssss = collect();
        if($propiedades)
        {
            foreach ($propiedades as $propiedad) 
            {
                $fotos = Foto::where('idPropiedad', $propiedad->id)->limit(20)->get();
                $fotosFinales = array();
                if($fotos)
                {
                    foreach ($fotos as $foto) 
                    {
                        $url = 'https://propitech.cl/img/propiedad/'. $foto->nombreArchivo.'"';
                        array_push($fotosFinales, $url);
                    }
                    $fotosAPublicar = implode(", ", $fotosFinales);
                }
                if($propiedad->idTipoComercial == 1)
                {
                    $tipoOperacion = 'venta';
                    $moneda = 'uf';
                    $precio = $propiedad->precio;
                }
                else
                {
                    $tipoOperacion = 'arriendo';
                    $moneda = 'peso';
                    $precio = $propiedad->valorArriendo;
                }
                if($propiedad->idTipoPropiedad == 1)
                {
                    $tipoPropiedad = 'casa';
                }
                elseif($propiedad->idTipoPropiedad == 2)
                {
                    $tipoPropiedad = 'departamento';
                }
                elseif($propiedad->idTipoPropiedad == 3)
                {
                    $tipoPropiedad = 'sitio';
                }
                elseif($propiedad->idTipoPropiedad == 4)
                {
                    $tipoPropiedad = '';
                }
                elseif($propiedad->idTipoPropiedad == 5)
                {
                    $tipoPropiedad = 'parcela';
                }
                elseif($propiedad->idTipoPropiedad == 6)
                {
                    $tipoPropiedad = '';
                }
                elseif($propiedad->idTipoPropiedad == 7)
                {
                    $tipoPropiedad = 'house';
                }
                elseif($propiedad->idTipoPropiedad == 8)
                {
                    $tipoPropiedad = 'oficina';
                }
                elseif($propiedad->idTipoPropiedad == 9)
                {
                    $tipoPropiedad = 'departamento';
                }
                elseif($propiedad->idTipoPropiedad == 10)
                {
                    $tipoPropiedad = 'local';
                }
                $fotosss = json_encode($fotosFinales);
                $descripcion = json_encode($propiedad->descripcion2, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                
                if($propiedad->usoGoceEstacionamiento > 0)
                {
                    $request = '{"ad": {
                            "externalID": "'.$propiedad->id.'",
                            "category": "'.$tipoOperacion.'",
                            "subCategory": "'.$tipoPropiedad.'",
                            "description": '.$descripcion.',
                            "attributes": {
                                "rooms": "'.$propiedad->habitacion.'",
                                "bathrooms": "'.$propiedad->bano.'",
                                "parkingLots": "'.$propiedad->usoGoceEstacionamiento.'",
                                "size": "'.$propiedad->mConstruido.'",
                                "utilSize": "'.$propiedad->mTotal.'"
                            },
                            "location": {
                                "address": "'.$propiedad->direccion.' '.$propiedad->numero.'",
                                "commune": "'.$propiedad->nombreComuna.'",
                                "geoposition": "'.$propiedad->latitud.','.$propiedad->longitud.'"
                            },
                            "price": "'.$precio.'",
                            "currency": "'.$moneda.'",
                            "externalAgentID": "'.$clientID.'",
                            "title": "'.$propiedad->nombrePropiedad.'",
                            "images":'.$fotosss.'
                        }
                    }';
                }   
                else
                {   
                    $request = '{"ad": {
                            "externalID": "'.$propiedad->id.'",
                            "category": "'.$tipoOperacion.'",
                            "subCategory": "'.$tipoPropiedad.'",
                            "description": '.$descripcion.',
                            "attributes": {
                                "rooms": "'.$propiedad->habitacion.'",
                                "bathrooms": "'.$propiedad->bano.'",
                                "size": "'.$propiedad->mConstruido.'",
                                "utilSize": "'.$propiedad->mTotal.'"
                            },
                            "location": {
                                "address": "'.$propiedad->direccion.' '.$propiedad->numero.'",
                                "commune": "'.$propiedad->nombreComuna.'",
                                "geoposition": "'.$propiedad->latitud.','.$propiedad->longitud.'"
                            },
                            "price": "'.$precio.'",
                            "currency": "'.$moneda.'",
                            "externalAgentID": "'.$clientID.'",
                            "title": "'.$propiedad->nombrePropiedad.'",
                            "images":'.$fotosss.'
                        }
                    }';
                }
                $propiedadessssss->push(json_decode($request));
            }
            return $propiedadessssss;
        }
    }
}
