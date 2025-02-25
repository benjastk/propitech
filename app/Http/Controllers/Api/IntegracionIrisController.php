<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Log;

class IntegracionIrisController extends Controller
{
    public function auth()
    {
        try
        {
            $urlAuthIris = getenv("IRIS_URL");
            $clientIDIris = getenv("IRIS_CLIENT_ID");
            $usernameIris = getenv("IRIS_USERNAME");
            $passwordIris = getenv("IRIS_PASSWORD");

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $urlAuthIris.'/auth/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "username": "'.$usernameIris.'",
                "password": "'.$passwordIris.'",
                "client_id": "'.$clientIDIris.'"
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
                $user->token_iris = $responseDos['access_token'];
                $user->save();
            }
            toastr()->success('Sesion inicidada correctamente en IRIS', 'Operacion exitosa');
            return redirect('/properties');
            //return response()->json($responseDos);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function getProyects()
    {
        try
        {
            $users = User::select('users.*')
            ->orderBy('id', 'asc')
            ->first();

            $urlAuthIris = getenv("IRIS_URL");
            $clientIDIris = getenv("IRIS_CLIENT_ID");
            $usernameIris = getenv("IRIS_USERNAME");
            $passwordIris = getenv("IRIS_PASSWORD");

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $urlAuthIris.'/projects/get-projects',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"filter":
                {"country":["7"],
                "project_status":["1","2"],
                "operation_type":"Venta",
                "identifiers":[],
                "level":"1"},
            "order":["promos","popularity"]}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$users->token_iris.''
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            return $responseDos = json_decode($response, true);

            toastr()->success('Sesion inicidada correctamente en IRIS', 'Operacion exitosa');
            return redirect('/properties');
            //return response()->json($responseDos);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
