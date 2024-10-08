<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
}
