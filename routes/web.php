<?php

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

Route::get('/oc/crear', function () { return view('main')->with(['component' => 'create-oc', 'title' => 'Crear Orden de Compra', 'id' => 0]); });
Route::get('/oc/editar/{id}', function ($id) { return view('main')->with(['component' => 'edit-oc', 'title' => 'Editar Orden de Compra', 'id' => $id]); });
Route::get('/oc', function () { return view('main')->with(['component' => 'index-oc', 'title' => 'Ordenes de Compra', 'id' => 0]); });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
