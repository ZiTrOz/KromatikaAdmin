<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    return view('main')->with(['component' => 'main', 'title' => '', 'id' => 0]);
});

Route::get('/defaultsite', function () {
    return view('main')->with(['component' => 'main', 'title' => '', 'id' => 0]);
});

Route::get('/ordentrabajo/crear', function () { return view('main')->with(['component' => 'create-wo', 'title' => 'Crear Orden de Trabajo', 'id' => 0]); });
Route::get('/ordentrabajo/editar/{id}', function ($id) { return view('main')->with(['component' => 'edit-wo', 'title' => 'Editar Orden de Trabajo', 'id' => $id]); });
Route::get('/ordentrabajo', function () { return view('main')->with(['component' => 'index-wo', 'title' => 'Ordenes de Trabajo', 'id' => 0]); });
Route::get('/ordentrabajo/entrega/{id}', function ($id) { return view('main')->with(['component' => 'delivery-wo', 'title' => 'Entrega de Pedido', 'id' => $id]); });
Route::get('/ordentrabajo/detalle/{id}', function ($id) { return view('main')->with(['component' => 'detail-wo', 'title' => 'Detalle de la Orden de Trabajo', 'id' => $id]); });
Route::post('/po/delivery/{id}', 'WoController@delivery');
Route::get('/po/search/{term}', 'WoController@search');

Route::get('/almacen', function () { return view('main')->with(['component' => 'warehouse-index', 'title' => 'Almacen', 'id' => 0]); });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/almacen/ubicaciones', function () { return view('main')->with(['component' => 'locations-index', 'title' => 'Ubicaciones', 'id' => 0]); });
Route::get('/almacen/transacciones', function () { return view('main')->with(['component' => 'transactions-index', 'title' => 'Transacciones', 'id' => 0]); });
Route::get('/almacen/inventario', function () { return view('main')->with(['component' => 'inventory-index', 'title' => 'Inventario', 'id' => 0]); });

Route::get('/polls', function () {
    return view('welcome')
        ->with('component', 'polls');
});

Route::get('/polls-answers/{poll_slug}', function ($poll_slug) {
    return view('welcome')
        ->with('slug', $poll_slug)
        ->with('component', 'polls-answers');
});

Route::get('/encuesta/{id}', function ($id) {
    return view('main')
        ->with('component', 'poll-component')
        ->with(['title' => '', 'id' => $id]);
});

Route::get('/usuarios', function () { return view('main')->with(['component' => 'users-index', 'title' => 'Usuarios', 'id' => 0]); });
