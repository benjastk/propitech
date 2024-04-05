<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Auth;
use Log;

class IntegracionYapoController extends Controller
{
    public function auth()
    {
        $urlAuthYapo = getenv("YAPO_AUTH_URL");
        $clientID = getenv("YAPO_CLIENT_ID");
        $redirect_url = getenv("YAPO_REDIRECT_URL");
        return redirect()->to($urlAuthYapo.'/authorization?client_id='.$clientID.'&redirect_url='.$redirect_url);
    }
    public function getToken(Request $request)
    {
        try
        {
            $urlAuthYapo = getenv("YAPO_AUTH_URL");
            $clientID = getenv("YAPO_CLIENT_ID");
            $redirect_url = getenv("YAPO_REDIRECT_URL");
            $secretClient = getenv("YAPO_SECRET_CLIENT");
            $yapoApiUrl = getenv("YAPO_API_URL");
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $yapoApiUrl.'-auth/auth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "clientID": "'.$clientID.'",
                "clientSecret": "'.$secretClient.'",
                "code": "'.$request->code.'"
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
                $user->tokenYapo = $responseDos['accessToken'];
                $user->tiempoSesion = $responseDos['ttl'];
                $user->refreshTokenYapo = $responseDos['refreshToken'];
                $user->save();
            }
            toastr()->success('Sesion inicidada correctamente en Yapo.cl', 'Operacion exitosa');
            return redirect('/properties');
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
            $tokenRefreshYapo = $users[0]->refreshTokenYapo;
            $urlAuthYapo = getenv("YAPO_AUTH_URL");
            $clientID = getenv("YAPO_CLIENT_ID");
            $redirect_url = getenv("YAPO_REDIRECT_URL");
            $secretClient = getenv("YAPO_SECRET_CLIENT");
            $yapoApiUrl = getenv("YAPO_API_URL");
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $yapoApiUrl.'-auth/auth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "clientID": "'.$clientID.'",
                "clientSecret": "'.$secretClient.'",
                "refreshToken": "'.$tokenRefreshYapo.'"
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
                    $user->tokenYapo = $responseDos['accessToken'];
                    $user->tiempoSesion = $responseDos['ttl'];
                    $user->refreshTokenYapo = $responseDos['refreshToken'];
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
