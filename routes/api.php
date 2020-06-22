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

Route::resource('wo', 'WoController');
Route::get('/wo/filter/{filter}', 'WoController@filter');
Route::get('/wo/getByProcess/{process}', 'WoController@getByProcess');
Route::resource('production', 'ProductionController');
Route::resource('users', 'UserController');
Route::resource('delivery', 'DeliveryController');
Route::resource('locations', 'LocationController');
Route::resource('transaction', 'TransactionController');
Route::resource('inventory', 'InventoryController');

Route::post('delivery/firma/{id}', 'DeliveryController@saveFirma')->name('delivery');

Route::get('production/getdetail/{id}', 'ProductionController@getdetail')->name('getdetail');

Route::get('locations/getByWarehouse/{warehouse}', 'LocationController@getByWarehouse')->name('getByWarehouse');

Route::resource('polls', 'PollsController');

Route::post('store-event', 'PollsController@storeEvent');
