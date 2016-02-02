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

/* Start Employee */
Route::get('/Employee', 'POS\EmployeeController@index');

Route::get('/Employee/Create', 'POS\EmployeeController@create');
Route::post('/Employee/Create', 'POS\EmployeeController@postCreate');

Route::get('/Employee/Details/{id}', 'POS\EmployeeController@details');

Route::get('/Employee/Edit/{id}', 'POS\EmployeeController@edit');
Route::post('/Employee/Edit', 'POS\EmployeeController@postEdit');

Route::get('/Employee/Delete/{id}', 'POS\EmployeeController@delete');
Route::post('/Employee/PartialDelete', 'POS\EmployeeController@ajaxPartDelete');
Route::post('/Employee/CompleteDelete', 'POS\EmployeeController@ajaxCompDelete');

Route::post('/Employee/Punch', 'POS\EmployeeController@ajaxPunchEmployee');
/* End Employee */

Route::get('/addon/rfid/request', 'Addons\Rfid\RfidRequestController@index');
Route::post('/addon/rfid/request', 'Addons\Rfid\RfidRequestController@create');
Route::post('/addon/rfid/checkRequest', 'Addons\Rfid\RfidRequestController@checkTableRequest');

Route::get('/addon/rfid/table', 'Addons\Rfid\RfidTableController@index');

/* Start Schedule */
Route::get('/Schedule', 'POS\ScheduleController@index');

/* End Schedule */

/* Start Punch */
Route::get('/Punch', 'POS\PunchController@index');
/* End Punch */

/* Start Disponibility */
Route::get('/Disponibility', 'POS\DisponibilityController@index');
Route::get('/Disponibility/Create', 'POS\DisponibilityController@create');
Route::post('/Disponibility/Create', 'POS\DisponibilityController@postCreate');

Route::get('/Disponibility/Manage/{id}', 'POS\DisponibilityController@manage');
/* End Disponibility */

/* Start Punch */

/* End Punch */