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
Route::get('maps/{direccion}','Api\DataGeneralController@maps');
