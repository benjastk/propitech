<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            $user = User::where('id', Auth::user()->id)->first();
            if($user)
            {
                $user->tokenPortal = $responseDos->access_token;
                $user->tokenType = $responseDos->token_type;
                $user->tiempoSesionPortal = $responseDos->expires_in;
                $user->userIDPortal = $responseDos->user_id;
                $user->refreshTokenPortal = $responseDos->refresh_token;
                $user->save();
            }
            toastr()->success('Sesion inicidada correctamente en PORTALINMOBILIARIO', 'Operacion exitosa');
            return redirect('/properties');
            //return response()->json($responseDos);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
