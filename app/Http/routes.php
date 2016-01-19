<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/contact', 'PagesController@contact');
Route::get('/inventory', 'ERP\InventoriesController@index');
Route::get('/invntory/{slug}', 'ERP\InventoriesController@edit');
Route::post('/inventory/{slug}', 'ERP\InventoriesController@update');
Route::get('/itemtypes', 'ERP\ItemTypesController@index');
Route::get('/itemtypes/{slug}', 'ERP\ItemTypesController@edit');
Route::post('/itemtypes/{slug}', 'ERP\ItemTypesController@update');
Route::get('/items', 'ERP\ItemsController@index');
Route::get('/items/{slug}', 'ERP\ItemsController@edit');
Route::post('/items/{slug}', 'ERP\ItemsController@update');

Route::get('/addon/rfid/request', 'Addons\Rfid\RfidRequestController@index');
Route::post('/addon/rfid/request', 'Addons\Rfid\RfidRequestController@create');
Route::post('/addon/rfid/checkRequest', 'Addons\Rfid\RfidRequestController@checkTableRequest');
