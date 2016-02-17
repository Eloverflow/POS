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

Route::post('/Employee/Punch', 'POS\PunchController@ajaxPunchEmployee');
/* End Employee */

Route::get('/addon/rfid/request', 'Addons\Rfid\RfidRequestController@index');
Route::post('/addon/rfid/request', 'Addons\Rfid\RfidRequestController@create');
Route::post('/addon/rfid/checkRequest', 'Addons\Rfid\RfidRequestController@checkTableRequest');

Route::get('/addon/rfid/table', 'Addons\Rfid\RfidTableController@index');
Route::get('/addon/rfid/table/{slug}', 'Addons\Rfid\RfidTableController@edit');
Route::post('/addon/rfid/table/{slug}', 'Addons\Rfid\RfidTableController@update');
Route::post('/addon/rfid/beers', 'Addons\Rfid\RfidTableController@getBeers');

/* Start Schedule */
Route::get('/Schedule', 'POS\ScheduleController@index');

Route::get('/Schedule/Create', 'POS\ScheduleController@create');
Route::post('/Schedule/Create', 'POS\ScheduleController@postCreate');

Route::get('/Schedule/Edit/{id}', 'POS\ScheduleController@edit');
Route::post('/Schedule/Edit', 'POS\ScheduleController@postEdit');

Route::get('/Schedule/Delete/{id}', 'POS\ScheduleController@delete');
Route::delete('/Schedule/DeleteArch/{id}', 'POS\ScheduleController@deleteArch');
Route::delete('/Schedule/DeleteComp/{id}', 'POS\ScheduleController@deleteComp');

Route::get('/Schedule/View/{id}', 'POS\ScheduleController@details');

Route::post('/Schedule/AjaxFindDispos', 'POS\ScheduleController@AjaxFindDispos');
/* End Schedule */

/* Start Punch */
Route::get('/Punch', 'POS\PunchController@index');
/* End Punch */

/* Start Disponibility */
Route::get('/Disponibility', 'POS\DisponibilityController@index');

Route::get('/Disponibility/Create', 'POS\DisponibilityController@create');
Route::post('/Disponibility/Create', 'POS\DisponibilityController@postCreate');

Route::get('/Disponibility/Edit/{id}', 'POS\DisponibilityController@edit');
Route::post('/Disponibility/Edit', 'POS\DisponibilityController@postEdit');

Route::get('/Disponibility/Delete/{id}', 'POS\DisponibilityController@delete');
Route::delete('/Disponibility/DeleteArch/{id}', 'POS\DisponibilityController@deleteArch');
Route::delete('/Disponibility/DeleteComp/{id}', 'POS\DisponibilityController@deleteComp');

Route::get('/Disponibility/View/{id}', 'POS\DisponibilityController@details');
/* End Disponibility */

/* Start Punch */

/* End Punch */

