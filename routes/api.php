<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('getRegion','Api\DataGeneralController@getRegion');
Route::get('getProvincia','Api\DataGeneralController@getProvincia');
Route::get('getComuna','Api\DataGeneralController@getComuna');
Route::get('getComunaRegion','Api\DataGeneralController@getComunaRegion');
Route::get('maps/{direccion}','Api\DataGeneralController@maps');
Route::post('buscarUsuario','Api\DataGeneralController@buscarUsuario');
Route::post('buscarUsuarioPropietario','Api\DataGeneralController@buscarUsuarioPropietario');

Route::post('/storeCaracteristica', 'Api\CaracteristicaController@storeCaracteristica');
Route::post('/updateCaracteristica/{propiedad}', 'Api\CaracteristicaController@updateCaracteristica');
Route::post('/destroyCaracteristica', 'Api\CaracteristicaController@destroyCaracteristica');

Route::get('/all-properties-for-propit','Api\DataGeneralController@allPropertiesForPropit');
Route::get('/spam','Api\DataGeneralController@spam');

Route::get('getPropiedad','Api\DataGeneralController@getPropiedad');

Route::post('/otrospagos/condeu', 'PagoController@condeures');
Route::post('/otrospagos/notpag', 'PagoController@notpagres');
Route::post('/otrospagos/revpag', 'PagoController@revpag');

Route::post('/pago-arriendo-exitoso', 'PagoController@pagoArriendoExitoso');
Route::post('/pago-reserva-exitosa', 'PagoController@pagoReservaExitosa');

Route::get('/properties-sincronize','Api\BuyDepaIntegracionController@sincronizeProperties');

Route::get('/yapo/auth', 'Api\IntegracionYapoController@auth');
Route::get('/yapo/sync', 'Api\IntegracionYapoController@integracionMasivaYapoCL');
Route::get('/yapo/prueba', 'Api\IntegracionYapoController@prueba');

Route::get('/portalinmobiliario/redirect', 'Api\IntegracionPortalController@redirect');
Route::get('/portalinmobiliario/auth', 'Api\IntegracionPortalController@auth');

Route::get('indexVentas','Api\VentaController@indexVentas');
Route::post('cambiarVenta','Api\VentaController@cambiarVenta');

