<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Propiedad;
use App\Foto;
use App\User;
use Auth;
use Log;

class IntegracionPortalController extends Controller
{
    public function redirect()
    {
        $urlAuthPortal = "https://auth.mercadolibre.cl/authorization?response_type=code&client_id=";
        $clientID = getenv("PORTALINMOBILIARIO_CLIENT_ID");
        $redirect_url = getenv("PORTALINMOBILIARIO_REDIRECT_URL");
        return redirect()->to($urlAuthPortal.$clientID.'&redirect_uri='.$redirect_url);
    }
    public function auth(Request $request)
    {
        try
        {
            $urlAuthPortal = getenv("PORTALINMOBILIARIO_AUTH_URL");
            $clientIDPortal = getenv("PORTALINMOBILIARIO_CLIENT_ID");
            $redirectUrlPortal = getenv("PORTALINMOBILIARIO_REDIRECT_URL");
            $secretClientPortal = getenv("PORTALINMOBILIARIO_SECRET_CLIENT");
            $portalApiUrl = getenv("PORTALINMOBILIARIO_API_URL");

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $portalApiUrl.'/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "grant_type": "authorization_code",
                "client_id": "'.$clientIDPortal.'",
                "client_secret": "'.$secretClientPortal.'",
                "code": "'.$request->code.'",
                "redirect_uri": "'.$redirectUrlPortal.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $responseDos = json_decode($response, true);
            $user = User::where('id', 1)->first();
            if($user)
            {
                $user->tokenPortal = $responseDos['access_token'];
                $user->tokenType = $responseDos['token_type'];
                $user->tiempoSesionPortal = $responseDos['expires_in'];
                $user->userIDPortal = $responseDos['user_id'];
                $user->refreshTokenPortal = $responseDos['refresh_token'];
                $user->save();
            }
            toastr()->success('Sesion inicidada correctamente en PORTALINMOBILIARIO', 'Operacion exitosa');
            return redirect('/properties');
            //return response()->json($responseDos);
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

            $tokenRefreshPortal = $users[0]->refreshTokenPortal;
            $urlAuthPortal = getenv("PORTALINMOBILIARIO_AUTH_URL");
            $clientIDPortal = getenv("PORTALINMOBILIARIO_CLIENT_ID");
            $redirectUrlPortal = getenv("PORTALINMOBILIARIO_REDIRECT_URL");
            $secretClientPortal = getenv("PORTALINMOBILIARIO_SECRET_CLIENT");
            $portalApiUrl = getenv("PORTALINMOBILIARIO_API_URL");

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $portalApiUrl.'/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "grant_type": "refresh_token",
                "client_id": "'.$clientIDPortal.'",
                "client_secret": "'.$secretClientPortal.'",
                "refresh_token": "'.$tokenRefreshPortal.'"
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
                    $user->tokenPortal = $responseDos['access_token'];
                    $user->tokenType = $responseDos['token_type'];
                    $user->tiempoSesionPortal = $responseDos['expires_in'];
                    $user->userIDPortal = $responseDos['user_id'];
                    $user->refreshTokenPortal = $responseDos['refresh_token'];
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
        
    }
    public function storeProperties($id)
    {
        try {
            $clientIDPortal = getenv("PORTALINMOBILIARIO_CLIENT_ID");
            $urlPortal = getenv("PORTALINMOBILIARIO_API_URL");
            $propiedad = Propiedad::select('propiedades.*', 'niveles_uso_propiedad.nombreNivelUsoPropiedad', 'tipos_propiedades.nombreTipoPropiedad',
            'paises.nombrePais', 'provincia.nombre as nombreProvincia', 'region.nombre as nombreRegion', 'comuna.codigoComunaPortal', 'estados.nombreEstado')
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
                        $url = 'https://propitech.cl/img/propiedad/'. $foto->nombreArchivo;
                        array_push($fotosFinales, array('source' => $url));
                    }
                }
                if($propiedad->idTipoComercial == 1)
                {
                    $tipoOperacion = 'venta';
                    $moneda = 'CLF';
                    $precio = $propiedad->precio;
                    if($propiedad->idTipoPropiedad == 1)
                    {
                        $tipoPropiedad = 'casa';
                        $categoriaSelect = 'MLC157520';
                    }
                    elseif($propiedad->idTipoPropiedad == 2)
                    {
                        $tipoPropiedad = 'departamento';
                        $categoriaSelect = 'MLC1474';
                    }
                    elseif($propiedad->idTipoPropiedad == 3)
                    {
                        $tipoPropiedad = 'sitio';
                        $categoriaSelect = 'MLC1495';
                    }
                    elseif($propiedad->idTipoPropiedad == 4)
                    {
                        $tipoPropiedad = '';
                        $categoriaSelect = 'MLC1474';
                    }
                    elseif($propiedad->idTipoPropiedad == 5)
                    {
                        $tipoPropiedad = 'parcela';
                        $categoriaSelect = 'MLC50548';
                    }
                    elseif($propiedad->idTipoPropiedad == 6)
                    {
                        $tipoPropiedad = '';
                        $categoriaSelect = 'MLC1474';
                    }
                    elseif($propiedad->idTipoPropiedad == 7)
                    {
                        $tipoPropiedad = 'house';
                        $categoriaSelect = 'MLC1474';
                    }
                    elseif($propiedad->idTipoPropiedad == 8)
                    {
                        $tipoPropiedad = 'oficina';
                        $categoriaSelect = 'MLC50540';
                    }
                    elseif($propiedad->idTipoPropiedad == 9)
                    {
                        $tipoPropiedad = 'departamento';
                        $categoriaSelect = 'MLC1474';
                    }
                    elseif($propiedad->idTipoPropiedad == 10)
                    {
                        $tipoPropiedad = 'local';
                        $categoriaSelect = 'MLC79244';
                    }
                }
                else
                {
                    $tipoOperacion = 'arriendo';
                    $moneda = 'CLP';
                    $precio = $propiedad->valorArriendo;
                    if($propiedad->idTipoPropiedad == 1)
                    {
                        $tipoPropiedad = 'casa';
                        $categoriaSelect = 'MLC1467';
                    }
                    elseif($propiedad->idTipoPropiedad == 2)
                    {
                        $tipoPropiedad = 'departamento';
                        $categoriaSelect = 'MLC1473';
                    }
                    elseif($propiedad->idTipoPropiedad == 3)
                    {
                        $tipoPropiedad = 'sitio';
                        $categoriaSelect = 'MLC1494';
                    }
                    elseif($propiedad->idTipoPropiedad == 4)
                    {
                        $tipoPropiedad = '';
                        $categoriaSelect = 'MLC1473';
                    }
                    elseif($propiedad->idTipoPropiedad == 5)
                    {
                        $tipoPropiedad = 'parcela';
                        $categoriaSelect = 'MLC1494';
                    }
                    elseif($propiedad->idTipoPropiedad == 6)
                    {
                        $tipoPropiedad = '';
                        $categoriaSelect = 'MLC1473';
                    }
                    elseif($propiedad->idTipoPropiedad == 7)
                    {
                        $tipoPropiedad = 'house';
                        $categoriaSelect = 'MLC1473';
                    }
                    elseif($propiedad->idTipoPropiedad == 8)
                    {
                        $tipoPropiedad = 'oficina';
                        $categoriaSelect = 'MLC50539';
                    }
                    elseif($propiedad->idTipoPropiedad == 9)
                    {
                        $tipoPropiedad = 'departamento';
                        $categoriaSelect = 'MLC1473';
                    }
                    elseif($propiedad->idTipoPropiedad == 10)
                    {
                        $tipoPropiedad = 'local';
                        $categoriaSelect = 'MLC79243';
                    }
                }
                if($propiedad->usoGoceEstacionamiento == 1)
                {
                    $estacionamiento = 1;
                }
                else
                {
                    $estacionamiento = 0;
                }
                $fotosss = json_encode($fotosFinales);
                $descripcion = json_encode($propiedad->descripcion2, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                $request = '{"title": "'.$propiedad->nombrePropiedad.'",
                        "category_id": "'.$categoriaSelect.'",
                        "price": "'.$precio.'",
                        "currency_id": "'.$moneda.'",
                        "available_quantity": 1,
                        "buying_mode": "classified",
                        "listing_type_id": "free",
                        "condition": "not_specified",
                        "channels": 
                        [
                            "marketplace" 
                        ], 
                        "pictures": '.$fotosss.',
                        "location": {
                            "address_line": "'.$propiedad->direccion.' '.$propiedad->numero.'",
                            "city": {
                                "id": "'.$propiedad->codigoComunaPortal.'"
                            },
                            "latitude": '.$propiedad->latitud.',
                            "longitude": '.$propiedad->longitud.'
                        },
                        "attributes": [
                            {
                                "id": "FULL_BATHROOMS",
                                "value_name": "'.$propiedad->bano.'"
                            },
                            {
                                "id": "PARKING_LOTS",
                                "value_name": "'.$estacionamiento.'"
                            },
                            {
                                "id": "BEDROOMS",
                                "value_name": "'.$propiedad->habitacion.'"
                            },
                            {
                                "id": "COVERED_AREA",
                                "value_name": "'.$propiedad->mConstruido.' m²"
                            },
                            {
                                "id": "TOTAL_AREA",
                                "value_name": "'.$propiedad->mTotal.' m²"
                            }
                        ],
                        "description": { "plain_text": '.$descripcion.' }
                        }';
                $users = User::select('users.*', 'roles.nombre', 'roles.id as idRol')
                ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'rol_usuario.id_rol')
                ->whereIn('rol_usuario.id_rol', [1, 2])
                ->get();
                $tokenPortal = $users[0]->tokenPortal;
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $urlPortal.'/items/validate',
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
                    'Authorization: Bearer '.$tokenPortal
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $responseDos = json_decode($response, true);

                Log::info('Status', array('body' => $responseDos));
                if($responseDos['status'] == 200)
                {
                    $propiedad = Propiedad::where('id', $id)->first();
                    $propiedad->urlPortalInmobiliario = $responseDos['permalink'];
                    $propiedad->itemIDPortal = $responseDos['id'];
                    $propiedad->save();
                    toastr()->success('Sincronizacion completada a portalinmobiliario.cl', 'Operación Exitosa');
                    return back();
                }
                else
                {
                    return response()->json($responseDos);
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
    public function updateProperties(Request $request)
    {

    }
    public function deleteProperties(Request $request)
    {

    }
}
