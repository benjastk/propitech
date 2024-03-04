<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Propiedad;

class BuyDepaIntegracionController extends Controller
{
    public function getProperties()
    {
        try{
            $urlBuyDepa = getenv("URL_BUY_DEPA");
            $apiKeyBuyDepa = getenv("API_KEY_BUYDEPA");
            $json = $urlBuyDepa;
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
            $jsonfile = file_get_contents($json);
            $spam = json_decode($jsonfile);
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
        $responses = '{"properties": 
        [
            {
                "id": 1,
                "sku": 123456,
                "address": "LOS TRIGALES 7485",
                "commune": "LAS CONDES",
                "tower": "1",
                "floor": "1",
                "bedrooms": 4,
                "bathrooms": 3,
                "garage": "200",
                "storage": "201",
                "antiquity": "7",
                "developer": "Propitech Buydepa",
                "rent_end_date": "2024-31-12",
                "remodeling_status": "LISTO",
                "cap_rate": 5,
                "selling_price": 7800,
                "storage_selling_price": 100,
                "garage_selling_price": 200,
                "final_selling_price": 8100,
                "rent_price_clp": 800000,
                "contributions_clp": 0,
                "terrace_area": 5.5,
                "interior_area": 34.5,
                "orientation": "SUR",
                "description": "BONITA CASA EN LAS CONDES",
                "expenses_clp": 50000,
                "images": [
                    "https://buydepa.com/_next/image?url=https%3A%2F%2Fbuydepa-media.s3.amazonaws.com%2Fproducts%2F731%2F731_34_ccc9e80f86&w=1920&q=75",
                    "https://buydepa.com/_next/image?url=https%3A%2F%2Fbuydepa-media.s3.amazonaws.com%2Fproducts%2F731%2F731_33_342caa7aa8&w=1920&q=75"
                ]
            }
        ]}';
        $propiedades = json_decode($responses, true);
        try{
            //$propiedades = self::getProperties();
            // crear nuevas propiedades
            if($propiedades)
            {
                if($propiedades->properties)
                {
                    $propiedadesDesde = $propiedades->properties;
                    $existe = false;
                    foreach ($propiedadesDesde as $propiedad) 
                    {
                        $existePropiedad = Propiedad::where('id')
                        ->where('idBuyDepa', $propiedad->id)
                        ->first();
                        if($existePropiedad)
                        {
                            $existe = true;
                        }
                    }
                    if($existe)
                    {

                    }
                    else
                    {
                        /*$propiedadACrear = new Propiedad();
                        $propiedadACrear->idNivelUsoPropiedad = $propiedad->id;
                        $propiedadACrear->idNivelUsoPropiedad = $request->get('about');
                        $propiedadACrear->idTipoComercial = 1;
                        $propiedadACrear->mostrarTituloAutomatico = 1;
                        $propiedadACrear->idTipoPropiedad = 2;
                        $propiedadACrear->nombrePropiedad = $propiedad->id;
                        $propiedadACrear->valorArriendo = ;
                        $propiedadACrear->gastosComunes = ;
                        $propiedadACrear->contribucion = ;
                        $propiedadACrear->idPais = ;
                        $propiedadACrear->idRegion = ;
                        $propiedadACrear->idProvincia = ;
                        $propiedadACrear->idComuna = ;
                        $propiedadACrear->direccion = ;
                        $propiedadACrear->numero = ;
                        $propiedadACrear->block = ;
                        $propiedadACrear->idBuyDepa = ;
                        $propiedadACrear->idBuyDepa = ;
                        $propiedadACrear->idBuyDepa = ;
                        $propiedadACrear->idBuyDepa = ;
                        $propiedadACrear->idBuyDepa = ;
                        $propiedadACrear->idBuyDepa = ;
                        $propiedadACrear->idBuyDepa = ;
                        [
                            '' => 1,
                            '' => $propiedad,
                            '' => 2,
                            '' => ($propiedad->selling_price > 0) ? $propiedad->final_selling_price : 0,
                            '' => ($propiedad->rent_price_clp > 0) ? $propiedad->rent_price_clp : 0,
                            '' => $propiedad->expenses_clp,
                            '' => $propiedad->contributions_clp,
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            'mTotal' => $propiedad->interior_area + $propiedad->terrace_area,
                            'mConstruido' => $propiedad->interior_area,
                            'mTerraza' => $propiedad->terrace_area,
                            'bano' => $propiedad->bathrooms,
                            'habitacion' => $propiedad->bedrooms,
                            'numeroPisos' => $propiedad->floor,
                            'latitud',
                            'longitud',
                            'descripcion' => $propiedad->description,
                            'descripcion2' => $propiedad->description,
                            'notaInterna' => 'CREADA AUTOMATICAMENTE DESDE BUYDEPA',
                            'idEstado' => 42,
                            'creador' => 'BUY DEPA',
                            'fotoPrincipal',
                            'estacionamiento' => ($propiedad->garage) ? $propiedad->garage : null,
                            'usoGoceEstacionamiento' => ($propiedad->garage) ? 1 : 0,
                            'codigoEstacionamiento' => ($propiedad->garage) ? $propiedad->garage : null,
                            'bodega' => ($propiedad->storage) ? $propiedad->storage : null,
                            'usoGoceBodega' => ($propiedad->storage) ? 1 : 0,
                            'codigoBodega' => ($propiedad->storage) ? $propiedad->storage : null,
                            'score' => $propiedad->cap_rate,
                            'orientacion' => $propiedad->orientation,
                            'esBuyDepa' => 1,
                            'idBuyDepa' => $propiedad->id,
                            'skuBuyDepa' => $propiedad->sku
                        ]*/
                    }
                }
            }
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
}
