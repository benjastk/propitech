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
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('users')->group(function () {
    Route::get('/', 'UserController@index')->name('users');
    Route::get('/create', 'UserController@create');
    Route::post('/store', 'UserController@store');
    Route::get('/edit/{user}', 'UserController@edit');
    Route::post('/update/{user}', 'UserController@update');
    Route::post('/destroy', 'UserController@destroy');
});
Route::prefix('properties')->group(function () {
    Route::get('/', 'PropertyController@index')->name('properties');
    Route::get('/create', 'PropertyController@create');
    Route::post('/store', 'PropertyController@store');
    Route::get('/edit/{propiedad}', 'PropertyController@edit');
    Route::post('/update/{propiedad}', 'PropertyController@update');
    Route::post('/destroy', 'PropertyController@destroy');
});
