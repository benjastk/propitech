<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Propiedad;
use App\Foto;
use App\User;
use App\ParametroGeneral;
use App\Mail\LeadPortalInmobiliario;
use App\Mail\AlertaRefreshTokenPortal;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
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

            Log::info('DEBUG auth Portal Inmobiliario - claves recibidas', array(
                'keys' => is_array($responseDos) ? array_keys($responseDos) : 'respuesta no es array',
                'tiene_refresh_token' => is_array($responseDos) && array_key_exists('refresh_token', $responseDos),
            ));

            if ($result['httpcode'] < 200 || $result['httpcode'] > 299 || empty($responseDos['access_token']))
            {
                Log::info('error', array('httpcode' => $result['httpcode'], 'body' => $responseDos));
                toastr()->error($this->portalErrorMessage($responseDos), 'Error de autenticación');
                return redirect('/properties');
            }

            $user = $this->getPortalUsers()->first();
            if($user)
            {
                $user->tokenPortal = $responseDos['access_token'];
                $user->tokenType = $responseDos['token_type'] ?? $user->tokenType;
                $user->tiempoSesionPortal = $responseDos['expires_in'] ?? $user->tiempoSesionPortal;
                $user->userIDPortal = $responseDos['user_id'] ?? $user->userIDPortal;
                $user->refreshTokenPortal = $responseDos['refresh_token'] ?? $user->refreshTokenPortal;
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
                $this->alertarFalloRefreshToken('No hay usuarios habilitados para Portal Inmobiliario', 'N/A');
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

            if ($result['httpcode'] < 200 || $result['httpcode'] > 299 || empty($responseDos['access_token']))
            {
                Log::info('error', array('httpcode' => $result['httpcode'], 'body' => $responseDos));
                $this->alertarFalloRefreshToken('Mercado Libre rechazó el refresh del token', json_encode(array('httpcode' => $result['httpcode'], 'body' => $responseDos), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                return false;
            }

            foreach ($users as $user)
            {
                $user->tokenPortal = $responseDos['access_token'];
                $user->tokenType = $responseDos['token_type'] ?? $user->tokenType;
                $user->tiempoSesionPortal = $responseDos['expires_in'] ?? $user->tiempoSesionPortal;
                $user->userIDPortal = $responseDos['user_id'] ?? $user->userIDPortal;
                $user->refreshTokenPortal = $responseDos['refresh_token'] ?? $tokenRefreshPortal;
                $user->save();
            }
            Log::info('refreshToken Portal Inmobiliario ejecutado correctamente', array('fecha' => now()->toDateTimeString()));
            Cache::forget('alerta_refresh_token_portal_enviada');
            return true;
        } catch (\Exception $e) {
            Log::info('Info', array('error' => $e->getMessage()));
            $this->alertarFalloRefreshToken('Excepción al refrescar el token', $e->getMessage());
            return false;
        }
    }
    public function listAds()
    {

    }
    public function leadsWebhook(Request $request)
    {
        try
        {
            $payload = $request->all();
            Log::info('Notificacion Leads Portal Inmobiliario', $payload);

            $resource = $payload['resource'] ?? null;
            $leadData = null;

            if ($resource)
            {
                $portalUser = $this->getPortalUsers()->first();
                if ($portalUser && $portalUser->tokenPortal)
                {
                    $urlPortal = getenv('PORTALINMOBILIARIO_API_URL');
                    $result = $this->callPortalApi($urlPortal.$resource, 'GET', '', $portalUser->tokenPortal);
                    if ($result['httpcode'] > 199 && $result['httpcode'] < 300)
                    {
                        $leadData = $result['data'];
                    }
                    else
                    {
                        Log::info('error obteniendo lead de Portal Inmobiliario', array('httpcode' => $result['httpcode'], 'body' => $result['data']));
                    }
                }
            }

            $contacto = $leadData['contact'] ?? $leadData ?? [];
            $itemId = $leadData['item_id'] ?? null;

            $propiedadEncontrada = null;
            if ($itemId)
            {
                $propiedadEncontrada = Propiedad::select('propiedades.direccion', 'propiedades.numero', 'propiedades.block', 'comuna.nombre as nombreComuna')
                    ->leftJoin('comuna', 'comuna.id', '=', 'propiedades.idComuna')
                    ->where('propiedades.itemIDPortal', $itemId)
                    ->first();
            }

            $details = (object) [
                'nombre' => $contacto['name'] ?? null,
                'email' => $contacto['email'] ?? null,
                'telefono' => $contacto['phone'] ?? null,
                'mensaje' => $leadData['message'] ?? $leadData['comment'] ?? null,
                'itemId' => $itemId,
                'direccion' => $propiedadEncontrada ? trim($propiedadEncontrada->direccion.' '.$propiedadEncontrada->numero) : null,
                'block' => $propiedadEncontrada->block ?? null,
                'comuna' => $propiedadEncontrada->nombreComuna ?? null,
                'topic' => $payload['topic'] ?? null,
                'raw' => json_encode($leadData ?? $payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            ];

            Mail::to('beenjaahp@hotmail.com')
                ->cc('beenjaahp@gmail.com')
                ->send(new LeadPortalInmobiliario($details));

            return response()->json(['status' => 'ok'], 200);
        } catch (\Exception $e) {
            Log::info('error', array('body' => $e->getMessage()));
            return response()->json(['status' => 'ok'], 200);
        }
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
                if($propiedad->fotoPrincipal)
                {
                    array_push($fotosFinales, array('source' => 'https://propitech.cl/img/propiedad/'.$propiedad->fotoPrincipal));
                }
                if($fotos)
                {
                    foreach ($fotos as $foto)
                    {
                        $url = 'https://propitech.cl/img/propiedad/'. $foto->nombreArchivo;
                        array_push($fotosFinales, array('source' => $url));
                    }
                }
                $totalFotosFinales = count($fotosFinales);
                if($totalFotosFinales > 0 && $totalFotosFinales < 12)
                {
                    $i = 0;
                    while (count($fotosFinales) < 12)
                    {
                        $fuente = $fotosFinales[$i % $totalFotosFinales]['source'];
                        $fotosFinales[] = ['source' => $fuente.(strpos($fuente, '?') === false ? '?' : '&').'dup='.($i + 1)];
                        $i++;
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
                $textoPlano = $propiedad->descripcionLimpia;

                if ($propiedad->habitacion >= 1 && $propiedad->habitacion <= 4)
                {
                    $maxHabitantes = $propiedad->habitacion + 1;
                }
                else
                {
                    $maxHabitantes = 1;
                }

                $attributes = [
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
                    ['id' => 'MAX_GUESTS_NUMBER', 'value_name' => (string) $maxHabitantes],
                    ['id' => 'CMG_SITE', 'value_name' => 'POI'],
                ];
                if (!empty($propiedad->mTerraza))
                {
                    $attributes[] = ['id' => 'BALCONY_AREA', 'value_name' => $propiedad->mTerraza.' m²'];
                }
                if (!empty($propiedad->block))
                {
                    $attributes[] = ['id' => 'APARTMENT_NUMBER', 'value_name' => (string) $propiedad->block];
                }
                if (in_array($propiedad->idTipoPropiedad, [1, 2, 4, 6, 7, 9]))
                {
                    if (empty($propiedad->block))
                    {
                        $pisoUnidad = 1;
                    }
                    elseif (strlen((string) $propiedad->block) == 3)
                    {
                        $pisoUnidad = (int) substr((string) $propiedad->block, 0, 1);
                    }
                    else
                    {
                        $pisoUnidad = 1;
                    }

                    $attributes[] = ['id' => 'HAS_COMMON_LAUNDRY', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_MULTIPURPOSE_ROOM', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_SECURITY', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'SECURITY_TYPE', 'value_name' => '24 horas'];
                    $attributes[] = ['id' => 'UNIT_FLOOR', 'value_name' => (string) $pisoUnidad];
                    $attributes[] = ['id' => 'APARTMENTS_PER_FLOOR', 'value_name' => '10'];
                    $attributes[] = ['id' => 'FLOORS', 'value_name' => '30'];
                    $antiguedad = $propiedad->idNivelUsoPropiedad == 2 ? '2 años' : '5 años';
                    $attributes[] = ['id' => 'PROPERTY_AGE', 'value_name' => $antiguedad];
                    $attributes[] = ['id' => 'APARTMENT_PROPERTY_SUBTYPE', 'value_name' => 'Departamento'];
                    $attributes[] = ['id' => 'FACING', 'value_name' => 'NOSP'];
                    $attributes[] = ['id' => 'HAS_PLAYGROUND', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_BUSINESS_CENTER', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_TENNIS_COURT', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_FRONT_DESK', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_ROOF_GARDEN', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_PARTY_ROOM', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_LIFT', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_BASKETBALL_COURT', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_PADDLE_COURT', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_MULTIPLE_USE_COURT', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_INDOOR_FIREPLACE', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'WITH_GREEN_AREA', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'WITH_SOCCER_FIELD', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_GYM', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'WHEELCHAIR_RAMP', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_FRIDGE', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_SAUNA', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_CINEMA_HALL', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'PROFESSIONAL_USE_ALLOWED', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_NATURAL_GAS', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_TELEPHONE_LINE', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_CABLE_TV', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_AIR_CONDITIONING', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_HEATING', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_CISTERN', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_BOILER', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'WITH_LAUNDRY_CONNECTION', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'WITH_SOLAR_ENERGY', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'WITH_SATELITE_TV', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_ELECTRIC_GENERATOR', 'value_name' => 'No'];

                    $tieneTerraza = $propiedad->mTerraza > 0 ? 'Sí' : 'No';
                    $attributes[] = ['id' => 'HAS_BALCONY', 'value_name' => $tieneTerraza];
                    $attributes[] = ['id' => 'HAS_TERRACE', 'value_name' => $tieneTerraza];

                    $attributes[] = ['id' => 'HAS_KITCHEN', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_DINNING_ROOM', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_LIVING_ROOM', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_BEDROOM_SUITE', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_STUDY', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_JACUZZI', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_PATIO', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_CLOSETS', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_PLAYROOM', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_DRESSING_ROOM', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_LAUNDRY', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_HALF_BATH', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_BREAKFAST_BAR', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_MAID_ROOM', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_GARDEN', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_GRILL', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_SWIMMING_POOL', 'value_name' => 'No'];
                }

                $request = [
                    'title' => $propiedad->nombrePropiedad,
                    'category_id' => $categoriaSelect,
                    'price' => (string) $precio,
                    'currency_id' => $moneda,
                    'available_quantity' => 1,
                    'buying_mode' => 'classified',
                    'listing_type_id' => 'silver',
                    'condition' => 'not_specified',
                    'channels' => ['marketplace'],
                    'pictures' => $fotosFinales,
                    'location' => [
                        'address_line' => $propiedad->direccion.' '.$propiedad->numero,
                        'city' => ['id' => $propiedad->codigoComunaPortal],
                        'latitude' => (float) $propiedad->latitud,
                        'longitude' => (float) $propiedad->longitud,
                    ],
                    'attributes' => $attributes,
                ];
                $whatsapp = $this->portalWhatsapp();
                if ($whatsapp)
                {
                    $request['seller_contact'] = [
                        'country_code2' => '56',
                        'area_code2' => '56',
                        'phone2' => $whatsapp,
                    ];
                }
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
                if($propiedad->fotoPrincipal)
                {
                    array_push($fotosFinales, array('source' => 'https://propitech.cl/img/propiedad/'.$propiedad->fotoPrincipal));
                }
                if($fotos)
                {
                    foreach ($fotos as $foto)
                    {
                        $url = 'https://propitech.cl/img/propiedad/'. $foto->nombreArchivo;
                        array_push($fotosFinales, array('source' => $url));
                    }
                }
                $totalFotosFinales = count($fotosFinales);
                if($totalFotosFinales > 0 && $totalFotosFinales < 12)
                {
                    $i = 0;
                    while (count($fotosFinales) < 12)
                    {
                        $fuente = $fotosFinales[$i % $totalFotosFinales]['source'];
                        $fotosFinales[] = ['source' => $fuente.(strpos($fuente, '?') === false ? '?' : '&').'dup='.($i + 1)];
                        $i++;
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
                if ($propiedad->habitacion >= 1 && $propiedad->habitacion <= 4)
                {
                    $maxHabitantes = $propiedad->habitacion + 1;
                }
                else
                {
                    $maxHabitantes = 1;
                }

                $attributes = [
                    ['id' => 'ROOMS', 'value_name' => (string) $propiedad->habitacion],
                    ['id' => 'FULL_BATHROOMS', 'value_name' => (string) $propiedad->bano],
                    ['id' => 'PARKING_LOTS', 'value_name' => (string) $estacionamiento],
                    ['id' => 'WAREHOUSES', 'value_name' => (string) $bodega],
                    ['id' => 'BEDROOMS', 'value_name' => (string) $propiedad->habitacion],
                    ['id' => 'COVERED_AREA', 'value_name' => $propiedad->mConstruido.' m²'],
                    ['id' => 'TOTAL_AREA', 'value_name' => $propiedad->mTotal.' m²'],
                    ['id' => 'MAINTENANCE_FEE', 'value_name' => (string) $propiedad->gastosComunes],
                    ['id' => 'HAS_INTERNET_ACCESS', 'value_name' => 'Sí'],
                    ['id' => 'MAX_GUESTS_NUMBER', 'value_name' => (string) $maxHabitantes],
                    ['id' => 'CMG_SITE', 'value_name' => 'POI'],
                ];
                if (!empty($propiedad->mTerraza))
                {
                    $attributes[] = ['id' => 'BALCONY_AREA', 'value_name' => $propiedad->mTerraza.' m²'];
                }
                if (!empty($propiedad->block))
                {
                    $attributes[] = ['id' => 'APARTMENT_NUMBER', 'value_name' => (string) $propiedad->block];
                }
                if (in_array($propiedad->idTipoPropiedad, [1, 2, 4, 6, 7, 9]))
                {
                    if (empty($propiedad->block))
                    {
                        $pisoUnidad = 1;
                    }
                    elseif (strlen((string) $propiedad->block) == 3)
                    {
                        $pisoUnidad = (int) substr((string) $propiedad->block, 0, 1);
                    }
                    else
                    {
                        $pisoUnidad = 1;
                    }

                    $attributes[] = ['id' => 'HAS_COMMON_LAUNDRY', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_MULTIPURPOSE_ROOM', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_SECURITY', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'SECURITY_TYPE', 'value_name' => '24 horas'];
                    $attributes[] = ['id' => 'UNIT_FLOOR', 'value_name' => (string) $pisoUnidad];
                    $attributes[] = ['id' => 'APARTMENTS_PER_FLOOR', 'value_name' => '10'];
                    $attributes[] = ['id' => 'FLOORS', 'value_name' => '30'];
                    $antiguedad = $propiedad->idNivelUsoPropiedad == 2 ? '2 años' : '5 años';
                    $attributes[] = ['id' => 'PROPERTY_AGE', 'value_name' => $antiguedad];
                    $attributes[] = ['id' => 'APARTMENT_PROPERTY_SUBTYPE', 'value_name' => 'Departamento'];
                    $attributes[] = ['id' => 'FACING', 'value_name' => 'NOSP'];
                    $attributes[] = ['id' => 'HAS_PLAYGROUND', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_BUSINESS_CENTER', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_TENNIS_COURT', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_FRONT_DESK', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_ROOF_GARDEN', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_PARTY_ROOM', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_LIFT', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_BASKETBALL_COURT', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_PADDLE_COURT', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_MULTIPLE_USE_COURT', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_INDOOR_FIREPLACE', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'WITH_GREEN_AREA', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'WITH_SOCCER_FIELD', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_GYM', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'WHEELCHAIR_RAMP', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_FRIDGE', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_SAUNA', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_CINEMA_HALL', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'PROFESSIONAL_USE_ALLOWED', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_NATURAL_GAS', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_TELEPHONE_LINE', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_CABLE_TV', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_AIR_CONDITIONING', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_HEATING', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_CISTERN', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_BOILER', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'WITH_LAUNDRY_CONNECTION', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'WITH_SOLAR_ENERGY', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'WITH_SATELITE_TV', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_ELECTRIC_GENERATOR', 'value_name' => 'No'];

                    $tieneTerraza = $propiedad->mTerraza > 0 ? 'Sí' : 'No';
                    $attributes[] = ['id' => 'HAS_BALCONY', 'value_name' => $tieneTerraza];
                    $attributes[] = ['id' => 'HAS_TERRACE', 'value_name' => $tieneTerraza];

                    $attributes[] = ['id' => 'HAS_KITCHEN', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_DINNING_ROOM', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_LIVING_ROOM', 'value_name' => 'Sí'];
                    $attributes[] = ['id' => 'HAS_BEDROOM_SUITE', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_STUDY', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_JACUZZI', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_PATIO', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_CLOSETS', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_PLAYROOM', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_DRESSING_ROOM', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_LAUNDRY', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_HALF_BATH', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_BREAKFAST_BAR', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_MAID_ROOM', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_GARDEN', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_GRILL', 'value_name' => 'No'];
                    $attributes[] = ['id' => 'HAS_SWIMMING_POOL', 'value_name' => 'No'];
                }

                $request = [
                    'title' => $propiedad->nombrePropiedad,
                    'price' => (string) $precio,
                    'pictures' => $fotosFinales,
                    'location' => [
                        'address_line' => $propiedad->direccion.' '.$propiedad->numero,
                        'city' => ['id' => $propiedad->codigoComunaPortal],
                        'latitude' => (float) $propiedad->latitud,
                        'longitude' => (float) $propiedad->longitud,
                    ],
                    'attributes' => $attributes,
                ];
                $whatsapp = $this->portalWhatsapp();
                if ($whatsapp)
                {
                    $request['seller_contact'] = [
                        'country_code2' => '56',
                        'area_code2' => '56',
                        'phone2' => $whatsapp,
                    ];
                }
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
                    $textoPlano = $propiedad->descripcionLimpia;
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

                // Mercado Libre exige cerrar la publicación antes de poder eliminarla
                $close = $this->callPortalApi($urlPortal.'/items/'.$propiedad->itemIDPortal, 'PUT', json_encode(['status' => 'closed']), $tokenPortal);
                if($close['httpcode'] < 200 || $close['httpcode'] > 299)
                {
                    Log::info('error', array('httpcode' => $close['httpcode'], 'body' => $close['data']));
                    toastr()->error($this->portalErrorMessage($close['data']), 'Algo falló al eliminar');
                    return redirect('/properties');
                }

                $result = $this->callPortalApi($urlPortal.'/items/'.$propiedad->itemIDPortal, 'PUT', json_encode(['deleted' => true]), $tokenPortal);
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
            $portalUser = $this->getPortalUsers()->first();
            if(!$portalUser)
            {
                toastr()->error('No hay un usuario habilitado con sesión de Portal Inmobiliario', 'Algo falló');
                return redirect('/properties');
            }
            $tokenPortal = $portalUser->tokenPortal;

            // Mercado Libre exige cerrar la publicación antes de poder eliminarla
            $close = $this->callPortalApi($urlPortal.'/items/'.$code, 'PUT', json_encode(['status' => 'closed']), $tokenPortal);
            if($close['httpcode'] < 200 || $close['httpcode'] > 299)
            {
                Log::info('error', array('httpcode' => $close['httpcode'], 'body' => $close['data']));
                toastr()->error($this->portalErrorMessage($close['data']), 'Algo falló al eliminar');
                return redirect('/properties');
            }

            $result = $this->callPortalApi($urlPortal.'/items/'.$code, 'PUT', json_encode(['deleted' => true]), $tokenPortal);
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
            $textoPlano = $propiedad->descripcionLimpia;
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
        return User::where('users.id', 1)->get();
    }

    private function alertarFalloRefreshToken($motivo, $raw)
    {
        if (Cache::has('alerta_refresh_token_portal_enviada'))
        {
            return;
        }
        Cache::put('alerta_refresh_token_portal_enviada', true, now()->addHour());

        $details = (object) [
            'motivo' => $motivo,
            'fecha' => now()->toDateTimeString(),
            'raw' => $raw,
        ];
        Mail::to('beenjaahp@hotmail.com')->send(new AlertaRefreshTokenPortal($details));
    }

    private function portalWhatsapp()
    {
        $parametro = ParametroGeneral::obtener('TELEFONO WHATSAPP 2');
        if (!$parametro || !$parametro->valorParametro)
        {
            return null;
        }
        $numero = preg_replace('/\D/', '', $parametro->valorParametro);
        if (strpos($numero, '56') === 0)
        {
            $numero = substr($numero, 2);
        }
        return $numero ?: null;
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
