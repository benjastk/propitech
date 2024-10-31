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
                        $categoriaSelect = 'MLC157522';
                    }
                    elseif($propiedad->idTipoPropiedad == 3)
                    {
                        $tipoPropiedad = 'sitio';
                        $categoriaSelect = 'MLC1495';
                    }
                    elseif($propiedad->idTipoPropiedad == 4)
                    {
                        $tipoPropiedad = '';
                        $categoriaSelect = 'MLC157522';
                    }
                    elseif($propiedad->idTipoPropiedad == 5)
                    {
                        $tipoPropiedad = 'parcela';
                        $categoriaSelect = 'MLC6405';
                    }
                    elseif($propiedad->idTipoPropiedad == 6)
                    {
                        $tipoPropiedad = '';
                        $categoriaSelect = 'MLC157522';
                    }
                    elseif($propiedad->idTipoPropiedad == 7)
                    {
                        $tipoPropiedad = 'house';
                        $categoriaSelect = 'MLC157522';
                    }
                    elseif($propiedad->idTipoPropiedad == 8)
                    {
                        $tipoPropiedad = 'oficina';
                        $categoriaSelect = 'MLC157413';
                    }
                    elseif($propiedad->idTipoPropiedad == 9)
                    {
                        $tipoPropiedad = 'departamento';
                        $categoriaSelect = 'MLC157522';
                    }
                    elseif($propiedad->idTipoPropiedad == 10)
                    {
                        $tipoPropiedad = 'local';
                        $categoriaSelect = 'MLC50612';
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
                        $categoriaSelect = 'MLC183184';
                    }
                    elseif($propiedad->idTipoPropiedad == 2)
                    {
                        $tipoPropiedad = 'departamento';
                        $categoriaSelect = 'MLC183186';
                    }
                    elseif($propiedad->idTipoPropiedad == 3)
                    {
                        $tipoPropiedad = 'sitio';
                        $categoriaSelect = 'MLC6404';
                    }
                    elseif($propiedad->idTipoPropiedad == 4)
                    {
                        $tipoPropiedad = '';
                        $categoriaSelect = 'MLC183186';
                    }
                    elseif($propiedad->idTipoPropiedad == 5)
                    {
                        $tipoPropiedad = 'parcela';
                        $categoriaSelect = 'MLC6404';
                    }
                    elseif($propiedad->idTipoPropiedad == 6)
                    {
                        $tipoPropiedad = '';
                        $categoriaSelect = 'MLC183186';
                    }
                    elseif($propiedad->idTipoPropiedad == 7)
                    {
                        $tipoPropiedad = 'house';
                        $categoriaSelect = 'MLC183186';
                    }
                    elseif($propiedad->idTipoPropiedad == 8)
                    {
                        $tipoPropiedad = 'oficina';
                        $categoriaSelect = 'MLC183187';
                    }
                    elseif($propiedad->idTipoPropiedad == 9)
                    {
                        $tipoPropiedad = 'departamento';
                        $categoriaSelect = 'MLC183186';
                    }
                    elseif($propiedad->idTipoPropiedad == 10)
                    {
                        $tipoPropiedad = 'local';
                        $categoriaSelect = 'MLC50611';
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
                if($propiedad->usoGoceBodega == 1)
                {
                    $bodega = 1;
                }
                else
                {
                    $bodega = 0;
                }
                if($propiedad->idNivelUsoPropiedad == 2)
                {
                    $uso = "Nuevo";
                }
                else
                {
                    $uso = "Usado";
                }
                if($propiedad->mascotas == 1)
                {
                    $mascotas = "Sí";
                }
                else
                {   
                    $mascotas = "No";
                }
                $fotosss = json_encode($fotosFinales);
                $titulo = json_encode($propiedad->nombrePropiedad, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                $text = str_replace(['<br>', '<br/>', '<br />', '</p>', '</h1>'], '\n', $propiedad->descripcion2);

                // Elimina el resto de etiquetas HTML
                $textoPlano = strip_tags($text);

                // Decodifica las entidades HTML a caracteres comunes
                $textoPlano = html_entity_decode($textoPlano);

                // Elimina posibles espacios extra
                $textoPlano = trim($textoPlano);
                $request = '{"title": '.$titulo.',
                        "category_id": "'.$categoriaSelect.'",
                        "price": "'.$precio.'",
                        "currency_id": "'.$moneda.'",
                        "available_quantity": 1,
                        "buying_mode": "classified",
                        "listing_type_id": "silver",
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
                                "id": "ROOMS",
                                "value_name": "'.$propiedad->habitacion.'"
                            },
                            {
                                "id": "FULL_BATHROOMS",
                                "value_name": "'.$propiedad->bano.'"
                            },
                            {
                                "id": "PARKING_LOTS",
                                "value_name": "'.$estacionamiento.'"
                            },
                            {
                                "id": "WAREHOUSES",
                                "value_name": "'.$bodega.'"
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
                            },
                            {
                                "id": "MAINTENANCE_FEE",
                                "value_name": "'.$propiedad->gastosComunes.'"
                            },
                            {
                                "id": "HAS_INTERNET_ACCESS",
                                "value_name": "Sí"
                            },
                            {
                                "id": "HAS_TAP_WATER",
                                "value_name": "Sí"
                            },
                            {
                                "id": "HAS_GUEST_PARKING",
                                "value_name": "Sí"
                            },
                            {
                                "id": "FURNISHED",
                                "value_name": "No"
                            },
                            {
                                "id": "IS_SUITABLE_FOR_PETS",
                                "value_name": "'.$mascotas.'"
                            }
                        ]
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
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
                $responseDos = json_decode($response, true);
                if($httpcode > 199 && $httpcode < 300)
                {
                    $curlDos = curl_init();
                    curl_setopt_array($curlDos, array(
                    CURLOPT_URL => $urlPortal.'/items',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
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
                    $responses = curl_exec($curlDos);
                    $httpcodeDos = curl_getinfo($curlDos, CURLINFO_HTTP_CODE);
                    curl_close($curlDos);
                    $responseTres = json_decode($responses, true);
                    $propiedadActualizada = Propiedad::where('id', $id)->first();
                    $propiedadActualizada->urlPortalInmobiliario = $responseTres['permalink'];
                    $propiedadActualizada->itemIDPortal = $responseTres['id'];
                    $propiedadActualizada->save();
                    if($httpcodeDos > 199 && $httpcodeDos < 300)
                    {
                        // INICIO DESCRIPCION
                        $requestDos = '{
                            "plain_text": "'.$textoPlano.'"
                        }';
                        $curlTres = curl_init();
                        curl_setopt_array($curlTres, array(
                        CURLOPT_URL => $urlPortal.'/items/'.$responseTres['id'].'/description',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => $requestDos,
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            'Authorization: Bearer '.$tokenPortal
                            ),
                        ));
                        $responsesCuatro = curl_exec($curlTres);
                        curl_close($curlTres);
                        // FIN DESCRIPCION
                        toastr()->success('Subida a portalinmobiliario.cl', 'Operación Exitosa');
                        return redirect('/properties');
                    }
                    else
                    {
                        Log::info('error', array('body' => $responseTres));
                        toastr()->error($responseTres['message'], 'PUBLICACION CON PARAMETROS INVALIDOS');
                        return redirect('/properties');
                    }
                }
                else
                {
                    Log::info('error', array('body' => $responseDos));
                    toastr()->error($responseDos['message'], 'PUBLICACION CON PARAMETROS INVALIDOS');
                    return redirect('/properties');
                }
            }
            else
            {
                toastr()->error('Propiedad no encontrada', 'Algo fallo');
                return redirect('/properties');
            }
        } catch (\Exception $e) {
            Log::info('error', array('body' => $e->getMessage()));
            toastr()->error('Tenemos un problema al subir la publicacion', 'Algo Falló');
            return redirect('/properties');
        }
    }
    public function updateProperties($id)
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
            $publicacionAEditar = $propiedad->itemIDPortal;
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
                }
                else
                {
                    $tipoOperacion = 'arriendo';
                    $moneda = 'CLP';
                    $precio = $propiedad->valorArriendo;
                }
                if($propiedad->usoGoceEstacionamiento == 1)
                {
                    $estacionamiento = 1;
                }
                else
                {
                    $estacionamiento = 0;
                }
                if($propiedad->usoGoceBodega == 1)
                {
                    $bodega = 1;
                }
                else
                {
                    $bodega = 0;
                }
                $fotosss = json_encode($fotosFinales);
                $descripcion = json_encode($propiedad->descripcion2, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                $titulo = json_encode($propiedad->nombrePropiedad, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                $request = '{"title": '.$titulo.',
                        "price": "'.$precio.'",
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
                                "id": "ROOMS",
                                "value_name": "'.$propiedad->habitacion.'"
                            },
                            {
                                "id": "FULL_BATHROOMS",
                                "value_name": "'.$propiedad->bano.'"
                            },
                            {
                                "id": "PARKING_LOTS",
                                "value_name": "'.$estacionamiento.'"
                            },
                            {
                                "id": "WAREHOUSES",
                                "value_name": "'.$bodega.'"
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
                            },
                            {
                                "id": "CONDO_VALUE",
                                "value_name": "'.$propiedad->gastosComunes.'"
                            },
                            {
                                "id": "HAS_INTERNET_ACCESS",
                                "value_name": "242084"
                            }
                        ]
                        }';
                $users = User::select('users.*', 'roles.nombre', 'roles.id as idRol')
                ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'rol_usuario.id_rol')
                ->whereIn('rol_usuario.id_rol', [1, 2])
                ->get();
                $tokenPortal = $users[0]->tokenPortal;
                $curlDos = curl_init();
                curl_setopt_array($curlDos, array(
                CURLOPT_URL => $urlPortal.'/items/'.$publicacionAEditar,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_POSTFIELDS => $request,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$tokenPortal
                    ),
                ));
                $responses = curl_exec($curlDos);
                $httpcodeDos = curl_getinfo($curlDos, CURLINFO_HTTP_CODE);
                curl_close($curlDos);
                if($httpcodeDos > 199 && $httpcodeDos < 300)
                {
                    $text = str_replace(['<br>', '<br/>', '<br />', '</p>', '</h1>'], '\n', $propiedad->descripcion2);
                    $textoPlano = strip_tags($text);
                    $textoPlano = html_entity_decode($textoPlano);
                    $textoPlano = trim($textoPlano);
                    $requestDos = '{
                        "plain_text": "'.$textoPlano.'"
                    }';
                    $curlTres = curl_init();
                    curl_setopt_array($curlTres, array(
                    CURLOPT_URL => $urlPortal.'/items/'.$publicacionAEditar.'/description',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'PUT',
                    CURLOPT_POSTFIELDS => $requestDos,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Authorization: Bearer '.$tokenPortal
                        ),
                    ));
                    $responsesCuatro = curl_exec($curlTres);
                    curl_close($curlTres);
                    toastr()->success('Actualizado en portalinmobiliario.cl', 'Operación Exitosa');
                    return redirect('/properties');
                }
                else
                {
                    Log::info('error', array('body' => $responses));
                    toastr()->error($responses, 'PUBLICACION CON PARAMETROS INVALIDOS');
                    return redirect('/properties');
                }
            }
        } catch (\Exception $e) {
            Log::info('error', array('body' => $e->getMessage()));
            toastr()->error('Tenemos un problema al actualizar la publicacion', 'Algo Falló');
            return redirect('/properties');
        }
        
    }
    public function desativateProperties($id)
    {
        try {
            $clientIDPortal = getenv("PORTALINMOBILIARIO_CLIENT_ID");
            $urlPortal = getenv("PORTALINMOBILIARIO_API_URL");
            $request = '{
                "status": "closed"
            }';
            $users = User::select('users.*', 'roles.nombre', 'roles.id as idRol')
            ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'rol_usuario.id_rol')
            ->whereIn('rol_usuario.id_rol', [1, 2])
            ->get();
            $propiedad = Propiedad::where('id', $id)->first();
            if($propiedad)
            {
                $tokenPortal = $users[0]->tokenPortal;
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $urlPortal.'/items/'.$propiedad->itemIDPortal,
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
                    'Authorization: Bearer '.$tokenPortal
                    ),
                ));
                $response = curl_exec($curl);
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
                if($httpcode > 199 && $httpcode < 300)
                {
                    $propiedad->eliminadoPortalInmobiliario = 1;
                    $propiedad->save();
                    toastr()->success('Desactivado en portalinmobiliario.cl', 'Operación Exitosa');
                    return redirect('/properties');
                }
                else
                {
                    Log::info('error', array('body' => $response));
                    toastr()->error('revisar logs', 'Algo falló al eliminar');
                    return redirect('/properties');
                }
            }
            else
            {
                toastr()->error('No existe propiedad a eliminar', 'Algo falló');
                return redirect('/properties');
            }
        } catch (\Exception $e) {
            Log::info('error', array('body' => $e->getMessage()));
            toastr()->error('Tenemos un problema al subir la publicacion', 'Algo Falló');
            return back();
        }
    }
    public function deleteProperties($id)
    {
        try {
            $clientIDPortal = getenv("PORTALINMOBILIARIO_CLIENT_ID");
            $urlPortal = getenv("PORTALINMOBILIARIO_API_URL");
            $request = '{
                "deleted": "true"
            }';
            $users = User::select('users.*', 'roles.nombre', 'roles.id as idRol')
            ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'rol_usuario.id_rol')
            ->whereIn('rol_usuario.id_rol', [1, 2])
            ->get();
            $propiedad = Propiedad::where('id', $id)->first();
            if($propiedad)
            {
                $tokenPortal = $users[0]->tokenPortal;
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $urlPortal.'/items/'.$propiedad->itemIDPortal,
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
                    'Authorization: Bearer '.$tokenPortal
                    ),
                ));
                $response = curl_exec($curl);
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
                if($httpcode > 199 && $httpcode < 300)
                {
                    $propiedad->itemIDPortal = "";
                    $propiedad->urlPortalInmobiliario = "";
                    $propiedad->eliminadoPortalInmobiliario = 0;
                    $propiedad->save();
                    toastr()->success('Eliminado en portalinmobiliario.cl', 'Operación Exitosa');
                    return redirect('/properties');
                }
                else
                {
                    Log::info('error', array('body' => $response));
                    toastr()->error($response['message'], 'Algo falló al eliminar');
                    return redirect('/properties');
                }
            }
            else
            {
                toastr()->error('No existe propiedad a eliminar', 'Algo falló');
                return redirect('/properties');
            }
        } catch (\Exception $e) {
            Log::info('error', array('body' => $e->getMessage()));
            toastr()->error('Tenemos un problema al eliminar la publicacion', 'Algo Falló');
            return back();
        }
    }
    public function deletePropertiesPortal($code)
    {
        try {
            $clientIDPortal = getenv("PORTALINMOBILIARIO_CLIENT_ID");
            $urlPortal = getenv("PORTALINMOBILIARIO_API_URL");
            $request = '{
                "deleted": "true"
            }';
            $users = User::select('users.*', 'roles.nombre', 'roles.id as idRol')
            ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'rol_usuario.id_rol')
            ->whereIn('rol_usuario.id_rol', [1, 2])
            ->get();
            
            $tokenPortal = $users[0]->tokenPortal;
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $urlPortal.'/items/'.$code,
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
                'Authorization: Bearer '.$tokenPortal
                ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if($httpcode > 199 && $httpcode < 300)
            {
                toastr()->success('Eliminado en portalinmobiliario.cl', 'Operación Exitosa');
                return redirect('/properties');
            }
            else
            {
                Log::info('error', array('body' => $response));
                toastr()->error($response['message'], 'Algo falló al eliminar');
                return redirect('/properties');
            }
        } catch (\Exception $e) {
            Log::info('error', array('body' => $e->getMessage()));
            toastr()->error('Tenemos un problema al eliminar la publicacion', 'Algo Falló');
            return back();
        }
    }
}
