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
        $redirectUrl = getenv("PORTALINMOBILIARIO_REDIRECT_URL");

        $state = bin2hex(random_bytes(16));
        session(['portalinmobiliario_oauth_state' => $state]);

        return redirect()->to($urlAuthPortal.$clientID
            .'&redirect_uri='.rawurlencode($redirectUrl)
            .'&state='.$state);
    }
    public function auth(Request $request)
    {
        try
        {
            $expectedState = session('portalinmobiliario_oauth_state');
            session()->forget('portalinmobiliario_oauth_state');
            if (!$expectedState || !$request->filled('state') || !hash_equals($expectedState, (string) $request->state))
            {
                toastr()->error('Solicitud de autorización inválida o expirada', 'Error de autenticación');
                return redirect('/properties');
            }

            $clientIDPortal = getenv("PORTALINMOBILIARIO_CLIENT_ID");
            $redirectUrlPortal = getenv("PORTALINMOBILIARIO_REDIRECT_URL");
            $secretClientPortal = getenv("PORTALINMOBILIARIO_SECRET_CLIENT");
            $portalApiUrl = getenv("PORTALINMOBILIARIO_API_URL");

            $result = $this->requestPortalToken($portalApiUrl, [
                'grant_type' => 'authorization_code',
                'client_id' => $clientIDPortal,
                'client_secret' => $secretClientPortal,
                'code' => $request->code,
                'redirect_uri' => $redirectUrlPortal,
            ]);
            $responseDos = $result['data'];

            $user = $this->getPortalUsers()->first();
            if($user)
            {
                $user->tokenPortal = $responseDos['access_token'] ?? null;
                $user->tokenType = $responseDos['token_type'] ?? null;
                $user->tiempoSesionPortal = $responseDos['expires_in'] ?? null;
                $user->userIDPortal = $responseDos['user_id'] ?? null;
                $user->refreshTokenPortal = $responseDos['refresh_token'] ?? null;
                $user->save();
                toastr()->success('Sesion inicidada correctamente en PORTALINMOBILIARIO', 'Operacion exitosa');
            }
            else
            {
                toastr()->error('No hay un usuario habilitado para recibir la sesión de Portal Inmobiliario', 'Algo falló');
            }
            return redirect('/properties');
        } catch (\Exception $e) {
            Log::info('error', array('body' => $e->getMessage()));
            toastr()->error('Tenemos un problema al iniciar sesión en Portal Inmobiliario', 'Algo Falló');
            return redirect('/properties');
        }
    }
    public function refreshToken()
    {
        try
        {
            $users = $this->getPortalUsers();
            if($users->isEmpty())
            {
                Log::info('error', array('body' => 'No hay usuarios habilitados para Portal Inmobiliario'));
                return false;
            }

            $tokenRefreshPortal = $users->first()->refreshTokenPortal;
            $clientIDPortal = getenv("PORTALINMOBILIARIO_CLIENT_ID");
            $secretClientPortal = getenv("PORTALINMOBILIARIO_SECRET_CLIENT");
            $portalApiUrl = getenv("PORTALINMOBILIARIO_API_URL");

            $result = $this->requestPortalToken($portalApiUrl, [
                'grant_type' => 'refresh_token',
                'client_id' => $clientIDPortal,
                'client_secret' => $secretClientPortal,
                'refresh_token' => $tokenRefreshPortal,
            ]);
            $responseDos = $result['data'];

            foreach ($users as $user)
            {
                $user->tokenPortal = $responseDos['access_token'] ?? null;
                $user->tokenType = $responseDos['token_type'] ?? null;
                $user->tiempoSesionPortal = $responseDos['expires_in'] ?? null;
                $user->userIDPortal = $responseDos['user_id'] ?? null;
                $user->refreshTokenPortal = $responseDos['refresh_token'] ?? null;
                $user->save();
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
                $text = str_replace(['<br>', '<br/>', '<br />', '</p>', '</h1>'], '\n', $propiedad->descripcion2);

                // Elimina el resto de etiquetas HTML
                $textoPlano = strip_tags($text);

                // Decodifica las entidades HTML a caracteres comunes
                $textoPlano = html_entity_decode($textoPlano);

                // Elimina posibles espacios extra
                $textoPlano = trim($textoPlano);

                $request = [
                    'title' => $propiedad->nombrePropiedad,
                    'category_id' => $categoriaSelect,
                    'price' => (string) $precio,
                    'currency_id' => $moneda,
                    'available_quantity' => 1,
                    'buying_mode' => 'classified',
                    'listing_type_id' => 'free',
                    'condition' => 'not_specified',
                    'channels' => ['marketplace'],
                    'pictures' => $fotosFinales,
                    'location' => [
                        'address_line' => $propiedad->direccion.' '.$propiedad->numero,
                        'city' => ['id' => $propiedad->codigoComunaPortal],
                        'latitude' => (float) $propiedad->latitud,
                        'longitude' => (float) $propiedad->longitud,
                    ],
                    'attributes' => [
                        ['id' => 'ROOMS', 'value_name' => (string) $propiedad->habitacion],
                        ['id' => 'FULL_BATHROOMS', 'value_name' => (string) $propiedad->bano],
                        ['id' => 'PARKING_LOTS', 'value_name' => (string) $estacionamiento],
                        ['id' => 'WAREHOUSES', 'value_name' => (string) $bodega],
                        ['id' => 'BEDROOMS', 'value_name' => (string) $propiedad->habitacion],
                        ['id' => 'COVERED_AREA', 'value_name' => $propiedad->mConstruido.' m²'],
                        ['id' => 'TOTAL_AREA', 'value_name' => $propiedad->mTotal.' m²'],
                        ['id' => 'MAINTENANCE_FEE', 'value_name' => (string) $propiedad->gastosComunes],
                        ['id' => 'HAS_INTERNET_ACCESS', 'value_name' => 'Sí'],
                        ['id' => 'HAS_TAP_WATER', 'value_name' => 'Sí'],
                        ['id' => 'HAS_GUEST_PARKING', 'value_name' => 'Sí'],
                        ['id' => 'FURNISHED', 'value_name' => 'No'],
                        ['id' => 'IS_SUITABLE_FOR_PETS', 'value_name' => $mascotas],
                        ['id' => 'CMG_SITE', 'value_name' => 'POI'],
                    ],
                ];
                $requestJson = json_encode($request, JSON_UNESCAPED_UNICODE);

                $portalUser = $this->getPortalUsers()->first();
                if(!$portalUser)
                {
                    toastr()->error('No hay un usuario habilitado con sesión de Portal Inmobiliario', 'Algo falló');
                    return redirect('/properties');
                }
                $tokenPortal = $portalUser->tokenPortal;

                $validate = $this->callPortalApi($urlPortal.'/items/validate', 'POST', $requestJson, $tokenPortal);
                $responseDos = $validate['data'];
                $httpcode = $validate['httpcode'];

                if($httpcode > 199 && $httpcode < 300)
                {
                    $create = $this->callPortalApi($urlPortal.'/items', 'POST', $requestJson, $tokenPortal);
                    $responseTres = $create['data'];
                    $httpcodeDos = $create['httpcode'];

                    $propiedadActualizada = Propiedad::where('id', $id)->first();
                    $propiedadActualizada->urlPortalInmobiliario = $responseTres['permalink'] ?? null;
                    $propiedadActualizada->itemIDPortal = $responseTres['id'] ?? null;
                    $propiedadActualizada->save();
                    if($httpcodeDos > 199 && $httpcodeDos < 300)
                    {
                        // INICIO DESCRIPCION
                        $requestDos = json_encode(['plain_text' => $textoPlano], JSON_UNESCAPED_UNICODE);
                        $this->callPortalApi($urlPortal.'/items/'.$responseTres['id'].'/description', 'POST', $requestDos, $tokenPortal);
                        // FIN DESCRIPCION
                        toastr()->success('Subida a portalinmobiliario.cl', 'Operación Exitosa');
                        return redirect('/properties');
                    }
                    else
                    {
                        Log::info('error', array('httpcode' => $httpcodeDos, 'body' => $responseTres));
                        toastr()->error($this->portalErrorMessage($responseTres), 'PUBLICACION CON PARAMETROS INVALIDOS');
                        return redirect('/properties');
                    }
                }
                else
                {
                    Log::info('error', array('httpcode' => $httpcode, 'body' => $responseDos));
                    toastr()->error($this->portalErrorMessage($responseDos), 'PUBLICACION CON PARAMETROS INVALIDOS');
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
                $publicacionAEditar = $propiedad->itemIDPortal;
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

                $request = [
                    'title' => $propiedad->nombrePropiedad,
                    'price' => (string) $precio,
                    'location' => [
                        'address_line' => $propiedad->direccion.' '.$propiedad->numero,
                        'city' => ['id' => $propiedad->codigoComunaPortal],
                        'latitude' => (float) $propiedad->latitud,
                        'longitude' => (float) $propiedad->longitud,
                    ],
                    'attributes' => [
                        ['id' => 'ROOMS', 'value_name' => (string) $propiedad->habitacion],
                        ['id' => 'FULL_BATHROOMS', 'value_name' => (string) $propiedad->bano],
                        ['id' => 'PARKING_LOTS', 'value_name' => (string) $estacionamiento],
                        ['id' => 'WAREHOUSES', 'value_name' => (string) $bodega],
                        ['id' => 'BEDROOMS', 'value_name' => (string) $propiedad->habitacion],
                        ['id' => 'COVERED_AREA', 'value_name' => $propiedad->mConstruido.' m²'],
                        ['id' => 'TOTAL_AREA', 'value_name' => $propiedad->mTotal.' m²'],
                        ['id' => 'CONDO_VALUE', 'value_name' => (string) $propiedad->gastosComunes],
                        ['id' => 'HAS_INTERNET_ACCESS', 'value_name' => 'Sí'],
                        ['id' => 'CMG_SITE', 'value_name' => 'POI'],
                    ],
                ];
                $requestJson = json_encode($request, JSON_UNESCAPED_UNICODE);

                $portalUser = $this->getPortalUsers()->first();
                if(!$portalUser)
                {
                    toastr()->error('No hay un usuario habilitado con sesión de Portal Inmobiliario', 'Algo falló');
                    return redirect('/properties');
                }
                $tokenPortal = $portalUser->tokenPortal;

                $update = $this->callPortalApi($urlPortal.'/items/'.$publicacionAEditar, 'PUT', $requestJson, $tokenPortal);
                $responses = $update['data'];
                $httpcodeDos = $update['httpcode'];

                if($httpcodeDos > 199 && $httpcodeDos < 300)
                {
                    $text = str_replace(['<br>', '<br/>', '<br />', '</p>', '</h1>'], '\n', $propiedad->descripcion2);
                    $textoPlano = strip_tags($text);
                    $textoPlano = html_entity_decode($textoPlano);
                    $textoPlano = trim($textoPlano);
                    $requestDos = json_encode(['plain_text' => $textoPlano], JSON_UNESCAPED_UNICODE);
                    $this->callPortalApi($urlPortal.'/items/'.$publicacionAEditar.'/description', 'PUT', $requestDos, $tokenPortal);
                    toastr()->success('Actualizado en portalinmobiliario.cl', 'Operación Exitosa');
                    return redirect('/properties');
                }
                else
                {
                    Log::info('error', array('httpcode' => $httpcodeDos, 'body' => $responses));
                    toastr()->error($this->portalErrorMessage($responses), 'PUBLICACION CON PARAMETROS INVALIDOS');
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
            toastr()->error('Tenemos un problema al actualizar la publicacion', 'Algo Falló');
            return redirect('/properties');
        }

    }
    public function desativateProperties($id)
    {
        try {
            $urlPortal = getenv("PORTALINMOBILIARIO_API_URL");
            $request = json_encode(['status' => 'closed']);
            $portalUser = $this->getPortalUsers()->first();
            $propiedad = Propiedad::where('id', $id)->first();
            if($propiedad)
            {
                if(!$portalUser)
                {
                    toastr()->error('No hay un usuario habilitado con sesión de Portal Inmobiliario', 'Algo falló');
                    return redirect('/properties');
                }
                $tokenPortal = $portalUser->tokenPortal;
                $result = $this->callPortalApi($urlPortal.'/items/'.$propiedad->itemIDPortal, 'PUT', $request, $tokenPortal);
                $httpcode = $result['httpcode'];
                if($httpcode > 199 && $httpcode < 300)
                {
                    $propiedad->eliminadoPortalInmobiliario = 1;
                    $propiedad->save();
                    toastr()->success('Desactivado en portalinmobiliario.cl', 'Operación Exitosa');
                    return redirect('/properties');
                }
                else
                {
                    Log::info('error', array('httpcode' => $httpcode, 'body' => $result['data']));
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
            $urlPortal = getenv("PORTALINMOBILIARIO_API_URL");
            $request = json_encode(['deleted' => 'true']);
            $portalUser = $this->getPortalUsers()->first();
            $propiedad = Propiedad::where('id', $id)->first();
            if($propiedad)
            {
                if(!$portalUser)
                {
                    toastr()->error('No hay un usuario habilitado con sesión de Portal Inmobiliario', 'Algo falló');
                    return redirect('/properties');
                }
                $tokenPortal = $portalUser->tokenPortal;
                $result = $this->callPortalApi($urlPortal.'/items/'.$propiedad->itemIDPortal, 'PUT', $request, $tokenPortal);
                $httpcode = $result['httpcode'];
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
                    Log::info('error', array('httpcode' => $httpcode, 'body' => $result['data']));
                    toastr()->error($this->portalErrorMessage($result['data']), 'Algo falló al eliminar');
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
            $urlPortal = getenv("PORTALINMOBILIARIO_API_URL");
            $request = json_encode(['deleted' => 'true']);
            $portalUser = $this->getPortalUsers()->first();
            if(!$portalUser)
            {
                toastr()->error('No hay un usuario habilitado con sesión de Portal Inmobiliario', 'Algo falló');
                return redirect('/properties');
            }
            $tokenPortal = $portalUser->tokenPortal;
            $result = $this->callPortalApi($urlPortal.'/items/'.$code, 'PUT', $request, $tokenPortal);
            $httpcode = $result['httpcode'];
            if($httpcode > 199 && $httpcode < 300)
            {
                toastr()->success('Eliminado en portalinmobiliario.cl', 'Operación Exitosa');
                return redirect('/properties');
            }
            else
            {
                Log::info('error', array('httpcode' => $httpcode, 'body' => $result['data']));
                toastr()->error($this->portalErrorMessage($result['data']), 'Algo falló al eliminar');
                return redirect('/properties');
            }
        } catch (\Exception $e) {
            Log::info('error', array('body' => $e->getMessage()));
            toastr()->error('Tenemos un problema al eliminar la publicacion', 'Algo Falló');
            return back();
        }
    }
    public function updateDescription($id)
    {
        try {
            $urlPortal = getenv("PORTALINMOBILIARIO_API_URL");

            $portalUser = $this->getPortalUsers()->first();
            $propiedad = Propiedad::where('id', $id)->first();
            if(!$propiedad)
            {
                toastr()->error('No existe la propiedad', 'Algo falló');
                return back();
            }
            if(!$portalUser)
            {
                toastr()->error('No hay un usuario habilitado con sesión de Portal Inmobiliario', 'Algo falló');
                return back();
            }
            $publicacionAEditar = $propiedad->itemIDPortal;
            $tokenPortal = $portalUser->tokenPortal;
            $text = str_replace(['<br>', '<br/>', '<br />', '</p>', '</h1>'], '\n', $propiedad->descripcion2);
            $textoPlano = strip_tags($text);
            $textoPlano = html_entity_decode($textoPlano);
            $textoPlano = trim($textoPlano);
            $requestDos = json_encode(['plain_text' => $textoPlano], JSON_UNESCAPED_UNICODE);

            $result = $this->callPortalApi($urlPortal.'/items/'.$publicacionAEditar.'/description', 'PUT', $requestDos, $tokenPortal);
            $httpcodeDos = $result['httpcode'];
            if($httpcodeDos > 199 && $httpcodeDos < 300)
            {
                toastr()->success('Descripcion actualizada en portalinmobiliario.cl', 'Operación Exitosa');
                return redirect('/properties/edit/'.$propiedad->id);
            }
            else
            {
                Log::info('error', array('httpcode' => $httpcodeDos, 'body' => $result['data']));
                toastr()->error($this->portalErrorMessage($result['data']), 'PUBLICACION CON PARAMETROS INVALIDOS');
                return redirect('/properties/edit/'.$propiedad->id);
            }
        } catch (\Exception $e) {
            Log::info('error', array('body' => $e->getMessage()));
            toastr()->error('Tenemos un problema al eliminar la publicacion', 'Algo Falló');
            return back();
        }
    }

    private function portalErrorMessage($data)
    {
        if (!is_array($data))
        {
            return 'Error desconocido';
        }
        if (!empty($data['message']))
        {
            return $data['message'];
        }
        if (!empty($data['cause']) && is_array($data['cause']))
        {
            $messages = array_filter(array_map(function ($cause) {
                return $cause['message'] ?? null;
            }, $data['cause']));
            if ($messages)
            {
                return implode(' | ', $messages);
            }
        }
        if (!empty($data['status']) && $data['status'] !== 'active')
        {
            $subStatus = !empty($data['sub_status']) ? ' ('.implode(', ', (array) $data['sub_status']).')' : '';
            return 'La publicación quedó en estado "'.$data['status'].'"'.$subStatus.'. Revisa el plan/medio de pago habilitado en Mercado Libre para Portal Inmobiliario.';
        }
        return 'Error desconocido';
    }

    private function getPortalUsers()
    {
        return User::select('users.*', 'roles.nombre', 'roles.id as idRol')
            ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'rol_usuario.id_rol')
            ->whereIn('rol_usuario.id_rol', [1, 2])
            ->get();
    }

    private function callPortalApi($url, $method, $body, $tokenPortal = null)
    {
        $headers = ['Content-Type: application/json'];
        if ($tokenPortal)
        {
            $headers[] = 'Authorization: Bearer '.$tokenPortal;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        if ($response === false)
        {
            $error = curl_error($curl);
            curl_close($curl);
            throw new \RuntimeException('Error de conexión con Portal Inmobiliario: '.$error);
        }
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return [
            'httpcode' => $httpcode,
            'data' => json_decode($response, true),
        ];
    }

    private function requestPortalToken($portalApiUrl, $fields)
    {
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
            CURLOPT_POSTFIELDS => http_build_query($fields),
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'content-type: application/x-www-form-urlencoded',
            ),
        ));

        $response = curl_exec($curl);
        if ($response === false)
        {
            $error = curl_error($curl);
            curl_close($curl);
            throw new \RuntimeException('Error de conexión con Portal Inmobiliario: '.$error);
        }
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return [
            'httpcode' => $httpcode,
            'data' => json_decode($response, true),
        ];
    }
}
