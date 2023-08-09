<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// front-end routes
Route::get('/', 'InicioController@comingSoon');
Route::get('/inicio', 'InicioController@index');
Route::post('/formulario-contacto-propiedades', 'ContactoController@contactoController')->name('formulario-contacto-propiedades');
Route::post('/formulario-canje-propiedades', 'ContactoController@formularioCanje')->name('formulario-canje-propiedades');
Route::post('/formulario-captador-propiedades', 'ContactoController@formularioCaptador')->name('formulario-captador-propiedades');


Route::post('/catalogo-propiedades', 'InicioController@list')->name('catalogo-propiedades');
Route::get('/catalogo-propiedades', 'InicioController@mapaCatalogoPropiedades');
Route::post('/catalogo-propiedades-venta', 'InicioController@listVenta')->name('catalogo-propiedades-venta');
Route::get('/catalogo-propiedades-venta', 'InicioController@mapaCatalogoPropiedadesVenta');
//ruta propiedades
Route::get('/propiedad-venta/{id}', 'InicioController@singleProperty');
Route::get('/propiedad-arriendo/{id}', 'InicioController@singleProperty');

Route::get('/servicios-administracion-propiedades', 'InicioController@servicios');
Route::get('/publica-tu-propiedad', 'InicioController@publicaTuPropiedad');
Route::get('/blog/{id}', 'InicioController@singleBlog');
Route::get('/nosotros', 'InicioController@nosotros');
Route::get('/trabaja-con-nosotros', 'InicioController@trabajaConNosotros');
Route::get('/preguntas-frecuentes', 'InicioController@preguntasFrecuentes');
Route::get('/terminos-condiciones', 'InicioController@terminosYCondiciones');

// back-office routes
Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/leads', 'HomeController@leads')->name('leads');
Route::prefix('users')->group(function () {
    Route::get('/', 'UserController@index')->name('users');
    Route::get('/create', 'UserController@create');
    Route::post('/store', 'UserController@store');
    Route::get('/edit/{user}', 'UserController@edit');
    Route::post('/update/{user}', 'UserController@update');
    Route::post('/destroy', 'UserController@destroy');

    Route::get('/cuentas-bancarias/{idUsuario}', 'UserController@cuentasBancarias');
    Route::post('/cuentas-bancarias/store', 'UserController@storeCuentaBancaria');
    Route::post('/cuentas-bancarias/update/{parametro}', 'UserController@updateCuentaBancaria');
    Route::post('/cuentas-bancarias/delete', 'UserController@deleteCuentaBancaria');
    Route::post('/reimpresionDeclaracionJurada', 'UserController@imprimirDeclaracionJurada');
});
Route::prefix('properties')->group(function () {
    Route::get('/', 'PropertyController@index')->name('properties');
    Route::get('/create', 'PropertyController@create');
    Route::post('/store', 'PropertyController@store');
    Route::get('/edit/{propiedad}', 'PropertyController@edit');
    Route::post('/update/{propiedad}', 'PropertyController@update');
    Route::post('/destroy', 'PropertyController@destroy');

    Route::post('/img/subir/{id}', 'PropertyController@subirImagen');
    Route::post('/img/eliminar/{fileName}', 'PropertyController@eliminarImagen');
    Route::get('/export', 'PropertyController@exportExcel')->name('export-properties');
});
Route::prefix('noticias')->group(function () {
    Route::get('/', 'NoticiaController@index')->name('noticias');
    Route::get('/create', 'NoticiaController@create');
    Route::post('/store', 'NoticiaController@store');
    Route::get('/edit/{propiedad}', 'NoticiaController@edit');
    Route::post('/update/{propiedad}', 'NoticiaController@update');
    Route::post('/destroy', 'NoticiaController@destroy');
});
Route::prefix('planes')->group(function () {
    Route::get('/', 'PlanesAdministracionController@index')->name('planes');
    Route::get('/create', 'PlanesAdministracionController@create');
    Route::post('/store', 'PlanesAdministracionController@store');
    Route::get('/edit/{propiedad}', 'PlanesAdministracionController@edit');
    Route::post('/update/{propiedad}', 'PlanesAdministracionController@update');
    Route::post('/destroy', 'PlanesAdministracionController@destroy');
});
Route::prefix('contratos')->group(function () {
    Route::get('/', 'ContratoArriendoController@index');
    Route::get('/contratos-propiedad/{idPropiedad}', 'ContratoArriendoController@show');
    Route::get('/create', 'ContratoArriendoController@create');
    Route::post('/store', 'ContratoArriendoController@store');
    Route::get('/edit/{contrato}', 'ContratoArriendoController@edit');
    Route::post('/update/{contrato}', 'ContratoArriendoController@update');
    Route::post('/destroy', 'ContratoArriendoController@destroy');

    Route::post('/reimpresionContratoArriendo', 'ContratoArriendoController@imprimirContratoArriendo');
    Route::post('/reimpresionSalvoconductoArriendo', 'ContratoArriendoController@imprimirSalvoconducto');
    Route::get('/export', 'ContratoArriendoController@exportExcel')->name('export-contratos');
});
Route::prefix('mandatos')->group(function () {
    Route::get('/', 'MandatoAdministracionController@index');
    Route::get('/mandatos-propiedad/{idPropiedad}', 'MandatoAdministracionController@show');
    Route::get('/create', 'MandatoAdministracionController@create');
    Route::post('/store', 'MandatoAdministracionController@store');
    Route::get('/edit/{contrato}', 'MandatoAdministracionController@edit');
    Route::post('/update/{contrato}', 'MandatoAdministracionController@update');
    Route::post('/destroy', 'MandatoAdministracionController@destroy');

    Route::post('/reimpresionMandatoAdministracion', 'MandatoAdministracionController@imprimirMandatoAdministracion');
    Route::get('/export', 'MandatoAdministracionController@exportExcel')->name('export-mandatos');
});
Route::prefix('estados-pagos')->group(function () {
    Route::get('/', 'EstadoPagoController@index');
    Route::get('/mostrar/{id}', 'EstadoPagoController@show');
    Route::get('/create', 'EstadoPagoController@create');
    Route::post('/store', 'EstadoPagoController@store');
    Route::get('/edit/{id}', 'EstadoPagoController@edit');
    Route::post('/update/{id}', 'EstadoPagoController@update');
    Route::post('/destroy', 'EstadoPagoController@destroy');

    Route::post('/createCargoDescuento', 'EstadoPagoController@createCargoDescuento');
    Route::post('/destroyCargoDescuento', 'EstadoPagoController@destroyCargoDescuento');
    
    Route::get('/pagos/{id}', 'EstadoPagoController@indexPagos');
    Route::post('/pago-manual', 'EstadoPagoController@pagoManual')->name('pagoManual');
    Route::post('/pago-manual-index', 'EstadoPagoController@pagoManualDesdeIndex')->name('pagoManualIndex');
    Route::post('/pagos/deletePago', 'EstadoPagoController@deletePago');
});
Route::prefix('parametros')->group(function () {
    Route::get('/', 'ParametrosGeneralesController@index');
    Route::get('/edit/{parametro}', 'ParametrosGeneralesController@edit');
    Route::post('/update/{parametro}', 'ParametrosGeneralesController@update');

    Route::get('/recordarPago', 'EstadoPagoController@recordarPago');
});
