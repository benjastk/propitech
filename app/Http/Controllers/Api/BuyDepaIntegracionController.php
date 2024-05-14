<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\CaracteristicasPorPropiedades;
use App\ActualizacionBuyDepa;
use App\LogTransaccion;
use App\Provincia;
use App\Propiedad;
use App\Comuna;
use App\Region;
use App\Pais;
use App\Foto;
use App\User;
use Image;

class BuyDepaIntegracionController extends Controller
{
    public function getProperties()
    {
        try{
            $urlBuyDepa = getenv("URL_BUY_DEPA");
            $apiKeyBuyDepa = getenv("API_KEY_BUYDEPA");
            $json = $urlBuyDepa.'/properties';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'x-api-key: '.$apiKeyBuyDepa
            ]);
            $response = curl_exec($ch);
            curl_close($ch);
            $spam = json_decode($response);
            return response()->json(['success' => true, 'data' => $response], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'data' => $e->getMessage()], 500);
        } catch (QueryException $e) {
            return response()->json(['success' => false, 'data' => $e->getMessage()], 500);
        } catch (DecryptException $e) {
            return response()->json(['success' => false, 'data' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => $e->getMessage()], 500);
        }
    }
    public function sincronizeProperties()
    {
        try{
            $urlBuyDepa = getenv("URL_BUY_DEPA");
            $apiKeyBuyDepa = getenv("API_KEY_BUYDEPA");
            $json = $urlBuyDepa.'/properties';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'x-api-key: '.$apiKeyBuyDepa
            ]);
            $response = curl_exec($ch);
            curl_close($ch);
            $spam = json_decode($response);

            $propiedades = json_decode($response, true);
            //return response()->json($propiedades);
            // crear o actualizar propiedades
            $propiedadesCreadas = 0;
            $propiedadesActualizadas = 0;
            $propiedadesEliminadas = 0;
            if($propiedades)
            {
                if($propiedades['properties'])
                {
                    $propiedadesDesde = $propiedades['properties'];
                    foreach ($propiedadesDesde as $key => $propiedad) 
                    {
                    if($key == 1)
                    {
                        set_time_limit(60);
                        $propiedadAEditar = Propiedad::where('idBuyDepa', $propiedad['id'])
                        ->first();
                        $comunaABuscar = Comuna::where('nombre', 'like', '%' . $propiedad['commune'] . '%')
                        ->first();
                        if($comunaABuscar)
                        {
                            $provinciaABuscar = Provincia::where('id', $comunaABuscar->idProvincia)
                            ->first();
                            $regionABuscar = Region::where('id', $provinciaABuscar->idRegion)
                            ->first();
                        }
                        if($propiedadAEditar)
                        {
                            if($propiedad['images'])
                            {
                                $propiedadAEditar->idNivelUsoPropiedad = 1;
                                $propiedadAEditar->idTipoComercial = 1;
                                $propiedadAEditar->mostrarTituloAutomatico = 1;
                                $propiedadAEditar->idTipoPropiedad = 2;
                                $propiedadAEditar->nombrePropiedad = "Dpto en venta ".$propiedad['bedrooms']. "hab+". $propiedad['bathrooms']. "Bañ, en ".$propiedad['commune'];
                                $propiedadAEditar->precio = ($propiedad['selling_price'] > 0) ? $propiedad['final_selling_price'] : 0;
                                $propiedadAEditar->valorArriendo = ($propiedad['rent_price_clp'] > 0) ? $propiedad['rent_price_clp'] : 0;
                                $propiedadAEditar->gastosComunes = $propiedad['expenses_clp'];
                                $propiedadAEditar->contribucion = $propiedad['contributions_clp'];
                                $propiedadAEditar->idPais = $regionABuscar->idPais;
                                $propiedadAEditar->idRegion = $regionABuscar->id;
                                $propiedadAEditar->idProvincia = $provinciaABuscar->id;
                                $propiedadAEditar->idComuna = $comunaABuscar->id;
                                $propiedadAEditar->direccion = $propiedad['address'];
                                $propiedadAEditar->numero = "";
                                $propiedadAEditar->block = "";
                                $propiedadAEditar->mTotal = $propiedad['interior_area'] + $propiedad['terrace_area'];
                                $propiedadAEditar->mConstruido = $propiedad['interior_area'];
                                $propiedadAEditar->mTerraza = $propiedad['terrace_area'];
                                $propiedadAEditar->bano = $propiedad['bathrooms'];
                                $propiedadAEditar->habitacion = $propiedad['bedrooms'];
                                $propiedadAEditar->numeroPisos = $propiedad['floor'];
                                $propiedadAEditar->latitud = $propiedad['latitude'];
                                $propiedadAEditar->longitud = $propiedad['longitude'];
                                if($propiedadAEditar->descripcion)
                                {

                                }
                                else
                                {
                                    $propiedadAEditar->descripcion = $propiedad['description'];
                                    $propiedadAEditar->descripcion2 = $propiedad['description'];
                                }
                                $propiedadAEditar->notaInterna = 'CREADA AUTOMATICAMENTE DESDE BUYDEPA';
                                $propiedadAEditar->idEstado = 42;
                                $propiedadAEditar->creador = 'BUY DEPA';
                                if($propiedadAEditar->fotoPrincipal)
                                {

                                }
                                else
                                {
                                    foreach ($propiedad['images'][0] as $imagen) 
                                    {
                                        $path = $imagen;
                                        if(str_contains($path, '.jpg') || str_contains($path, '.jpeg') || str_contains($path, '.png'))
                                        {
                                            $filename = basename($path);
                                            $img = Image::make($path);
                                            $img->insert(public_path('front/logoopacity2.png'), 'center');
                                            $img->save(public_path('img/propiedad/'.$filename));
                                        }
                                        else
                                        {
                                            $filename = basename($path).'.jpg';
                                            $img = Image::make($path);
                                            $img->insert(public_path('front/logoopacity2.png'), 'center');
                                            $img->save(public_path('img/propiedad/'.$filename));
                                        }
                                    }
                                    $propiedadAEditar->fotoPrincipal = $filename;
                                }
                                $propiedadAEditar->estacionamiento = ($propiedad['garage']) ? 1 : null;
                                $propiedadAEditar->usoGoceEstacionamiento = ($propiedad['garage']) ? 1 : 0;
                                $propiedadAEditar->codigoEstacionamiento = ($propiedad['garage']) ? $propiedad['garage'] : null;
                                $propiedadAEditar->bodega = ($propiedad['storage']) ? 1 : null;
                                $propiedadAEditar->usoGoceBodega = ($propiedad['storage']) ? 1 : 0;
                                $propiedadAEditar->codigoBodega = ($propiedad['storage']) ? $propiedad['storage'] : null;
                                $propiedadAEditar->score = $propiedad['cap_rate'];
                                $propiedadAEditar->orientacion = $propiedad['orientation'];
                                $propiedadAEditar->esBuyDepa = 1;
                                $propiedadAEditar->idBuyDepa = $propiedad['id'];
                                $propiedadAEditar->skuBuyDepa = $propiedad['sku'];
                                $propiedadAEditar->idBanco = null;
                                $propiedadAEditar->idUsuarioExpertoVendedor = 2;
                                $propiedadAEditar->save();
                                
                                $propiedadesActualizadas = $propiedadesActualizadas + 1;
                            }
                        }
                        else
                        {
                            if($propiedad['images'])
                            {
                                $path = $propiedad['images'][0];
                                if(str_contains($path, '.jpg') || str_contains($path, '.jpeg') || str_contains($path, '.png'))
                                {
                                    $filename = basename($path);
                                    $img = Image::make($path);
                                    $img->insert(public_path('front/logoopacity2.png'), 'center');
                                    $img->save(public_path('img/propiedad/'.$filename));
                                }
                                else
                                {
                                    $filename = basename($path).'.jpg';
                                    $img = Image::make($path);
                                    $img->insert(public_path('front/logoopacity2.png'), 'center');
                                    $img->save(public_path('img/propiedad/'.$filename));
                                }
                                $primeraFoto = $propiedad['images'][0];
                                $propiedadACrear = new Propiedad();
                                $propiedadACrear->idNivelUsoPropiedad = 1;
                                $propiedadACrear->idTipoComercial = 1;
                                $propiedadACrear->mostrarTituloAutomatico = 1;
                                $propiedadACrear->idTipoPropiedad = 2;
                                $propiedadACrear->nombrePropiedad = "Dpto en venta ".$propiedad['bedrooms']. "hab+". $propiedad['bathrooms']. "Bañ, en ".$propiedad['commune'];
                                $propiedadACrear->precio = ($propiedad['selling_price'] > 0) ? $propiedad['final_selling_price'] : 0;
                                $propiedadACrear->valorArriendo = ($propiedad['rent_price_clp'] > 0) ? $propiedad['rent_price_clp'] : 0;
                                $propiedadACrear->gastosComunes = $propiedad['expenses_clp'];
                                $propiedadACrear->contribucion = $propiedad['contributions_clp'];
                                $propiedadACrear->idPais = $regionABuscar->idPais;
                                $propiedadACrear->idRegion = $regionABuscar->id;
                                $propiedadACrear->idProvincia = $provinciaABuscar->id;
                                $propiedadACrear->idComuna = $comunaABuscar->id;
                                $propiedadACrear->direccion = $propiedad['address'];
                                $propiedadACrear->numero = "";
                                $propiedadACrear->block = "";
                                $propiedadACrear->mTotal = $propiedad['interior_area'] + $propiedad['terrace_area'];
                                $propiedadACrear->mConstruido = $propiedad['interior_area'];
                                $propiedadACrear->mTerraza = $propiedad['terrace_area'];
                                $propiedadACrear->bano = $propiedad['bathrooms'];
                                $propiedadACrear->habitacion = $propiedad['bedrooms'];
                                $propiedadACrear->numeroPisos = $propiedad['floor'];
                                $propiedadACrear->latitud = $propiedad['latitude'];
                                $propiedadACrear->longitud = $propiedad['longitude'];
                                $propiedadACrear->descripcion = $propiedad['description'];
                                $propiedadACrear->descripcion2 = $propiedad['description'];
                                $propiedadACrear->notaInterna = 'CREADA AUTOMATICAMENTE DESDE BUYDEPA';
                                $propiedadACrear->idEstado = 42;
                                $propiedadACrear->creador = 'BUY DEPA';
                                $propiedadACrear->fotoPrincipal = $filename;
                                $propiedadACrear->estacionamiento = ($propiedad['garage']) ? 1 : null;
                                $propiedadACrear->usoGoceEstacionamiento = ($propiedad['garage']) ? 1 : 0;
                                $propiedadACrear->codigoEstacionamiento = ($propiedad['garage']) ? $propiedad['garage'] : null;
                                $propiedadACrear->bodega = ($propiedad['storage']) ? 1 : null;
                                $propiedadACrear->usoGoceBodega = ($propiedad['storage']) ? 1 : 0;
                                $propiedadACrear->codigoBodega = ($propiedad['storage']) ? $propiedad['storage'] : null;
                                $propiedadACrear->score = $propiedad['cap_rate'];
                                $propiedadACrear->orientacion = $propiedad['orientation'];
                                $propiedadACrear->esBuyDepa = 1;
                                $propiedadACrear->idBuyDepa = $propiedad['id'];
                                $propiedadACrear->skuBuyDepa = $propiedad['sku'];
                                $propiedadACrear->idBanco = null;
                                $propiedadACrear->idUsuarioExpertoVendedor = 2;
                                $propiedadACrear->save();
                                if($propiedad['images'])
                                {
                                    foreach ($propiedad['images'] as $imagenes) 
                                    {
                                        if($imagenes == $primeraFoto)
                                        {

                                        }
                                        else
                                        {
                                            $path = $imagenes;
                                            if(str_contains($path, '.jpg') || str_contains($path, '.jpeg') || str_contains($path, '.png'))
                                            {
                                                $filenames = basename($path);
                                                $img = Image::make($path);
                                                $img->insert(public_path('front/logoopacity2.png'), 'center');
                                                $img->save(public_path('img/propiedad/'.$filenames));
                                                $foto = new Foto();
                                                $foto->idPropiedad = $propiedadACrear->id;
                                                $foto->nombreArchivo = $filenames;
                                                $foto->marcaDeAgua = 1;
                                                $foto->save();
                                            }
                                            else
                                            {
                                                $filenames = basename($path).'.jpg';
                                                $img = Image::make($path);
                                                $img->insert(public_path('front/logoopacity2.png'), 'center');
                                                $img->save(public_path('img/propiedad/'.$filenames));
                                                $foto = new Foto();
                                                $foto->idPropiedad = $propiedadACrear->id;
                                                $foto->nombreArchivo = $filenames;
                                                $foto->marcaDeAgua = 1;
                                                $foto->save();
                                            }
                                        }
                                    }
                                }
                                $caracteristicaPropiedad = new CaracteristicasPorPropiedades;
                                $caracteristicaPropiedad->idPropiedad = $propiedadACrear->id;
                                $caracteristicaPropiedad->idCaracteristicaPropiedad = 8;
                                $caracteristicaPropiedad->save();
                                $propiedadesCreadas = $propiedadesCreadas + 1;
                            }
                        }
                    }
                    }
                    $propiedadesEnSistema = Propiedad::where('esBuyDepa', 1)
                    ->where('idEstado', 42)
                    ->get();
                    if($propiedadesEnSistema)
                    {
                        $sumarEncontrados = 1;
                        foreach ($propiedadesEnSistema as $propiedadSistema) 
                        {
                            $searchResult = array_filter($propiedadesDesde, function ($propiedadDe) use($propiedadSistema)
                            {
                                return $propiedadDe['id'] === $propiedadSistema->idBuyDepa;
                            });
                            if($searchResult)
                            {
                                $sumarEncontrados = $sumarEncontrados + 1;
                            }
                            else
                            {
                                $fotos = Foto::where('idPropiedad', $propiedadSistema->id)->get();
                                if($fotos)
                                {
                                    foreach ($fotos as $foto) {
                                        File::delete(public_path('img/propiedad/' . $foto->nombreArchivo));
                                        $foto->delete();
                                    }
                                }
                                $caracteristicaPropiedad = CaracteristicasPorPropiedades::where('idPropiedad','=', $propiedadSistema->id)->get();
                                if($caracteristicaPropiedad)
                                {
                                    foreach ($caracteristicaPropiedad as $caracteristicaDeLaPropiedad ) {
                                        $caracteristicaDeLaPropiedad->delete();
                                    }
                                }
                                $clientID = getenv("YAPO_CLIENT_ID");
                                $propiedad = Propiedad::where('id', '=', $propiedadSistema->id)
                                ->first();
                                $users = User::select('users.*', 'roles.nombre', 'roles.id as idRol')
                                ->join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
                                ->join('roles', 'roles.id', '=', 'rol_usuario.id_rol')
                                ->whereIn('rol_usuario.id_rol', [1, 2])
                                ->get();
                                if($propiedadSistema->externalIDYapo > 1)
                                {                
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
                                        "externalID": "'.$propiedadSistema->id.'"
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
                                        $propiedad = Propiedad::where('id', $propiedadSistema->id)->first();
                                        $propiedad->urlYapo = null;
                                        $propiedad->internalIDYapo = null;
                                        $propiedad->listIDYapo = null;
                                        $propiedad->externalIDYapo = null;
                                        $propiedad->save();
                                    }
                                }
                                $logTransaccion = new LogTransaccion();
                                $logTransaccion->tipoTransaccion = 'PROPIEDAD ELIMINADA EN BUYDEPA';
                                $logTransaccion->idUsuario =  $users[0]->id;
                                $logTransaccion->descripcionTransaccion = 'Propiedad eliminada en buydepa'. $propiedadSistema->direccion. ' '. $propiedadSistema->numero;
                                $logTransaccion->save();
                                $propiedadSistema->delete();
                                $propiedadesEliminadas = $propiedadesEliminadas + 1;
                            }
                        }
                    }
                }
            }
            $actualizacion = new ActualizacionBuyDepa();
            $actualizacion->creadas = $propiedadesCreadas;
            $actualizacion->actualizadas = $propiedadesActualizadas;
            $actualizacion->eliminadas = $propiedadesEliminadas;
            $actualizacion->save();
            return response()->json(['success' => true, 'data' => "OK"], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'data' => $e->getMessage()], 500);
        } catch (QueryException $e) {
            return response()->json(['success' => false, 'data' => $e->getMessage()], 500);
        } catch (DecryptException $e) {
            return response()->json(['success' => false, 'data' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => $e->getMessage()], 500);
        }
    }
}
