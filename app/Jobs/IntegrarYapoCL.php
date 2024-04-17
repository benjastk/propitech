<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\LogTransacciones;
use App\Propiedad;
use App\Foto;
use App\User;
use Auth;
use Log;

class IntegrarYapoCL implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
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
                    
                    if($responseDos['status'] == 200)
                    {
                        $propiedad = Propiedad::where('id', $propiedad->id)->first();
                        $propiedad->urlYapo = $responseDos['ad']['url'];
                        $propiedad->internalIDYapo = $responseDos['ad']['internalID'];
                        $propiedad->listIDYapo = $responseDos['ad']['listID'];
                        $propiedad->externalIDYapo = $responseDos['ad']['externalID'];
                        $propiedad->save();
                        Log::info('success', array('body' => 'listo'));
                        return true;
                    }
                    else
                    {
                        Log::info('error', array('body' => 'Error yapo'));
                        return true;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::info('error', array('body' => $e->getMessage()));
            return true;
        }
    }
}
