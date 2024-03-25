<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MercadoLibreIntegrationController extends Controller
{
    public function applications()
    {
        $idApp = getenv("MERCADOLIBRE_ID_APP");
        $tokenApp = getenv("MERCADOLIBRE_TOKEN_APP");
        $urlMercadoLibre = getenv("MERCADOLIBRE_URL");
        $urlRequest = $urlMercadoLibre.'/applications/'.$idApp;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlRequest);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '.$tokenApp
        ]);
        $responseMercadoLibre = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($responseMercadoLibre);
        return response()->json($response);
    }
}
