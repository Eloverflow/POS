

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

/* Start Authentication */
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
/* End Authentication */



Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/contact', 'PagesController@contact');

Route::get('/inventory', 'ERP\InventoriesController@index');
Route::get('/inventory/edit',  function() { return Redirect::to('/inventory');});
Route::get('/inventory/edit/{slug}', 'ERP\InventoriesController@edit');
Route::get('/inventory/view',  function() { return Redirect::to('/inventory');});
Route::get('/inventory/view/{slug}', 'ERP\InventoriesController@details');
Route::post('/inventory/edit/{slug}', 'ERP\InventoriesController@update');
Route::get('/inventory/create', 'ERP\InventoriesController@create');
Route::post('/inventory/create', 'ERP\InventoriesController@postCreate');



Route::get('/itemtypes', 'ERP\ItemTypesController@index');
Route::get('/itemtypes/edit/{slug}', 'ERP\ItemTypesController@edit');
Route::post('/itemtypes/edit/{slug}', 'ERP\ItemTypesController@update');

Route::get('/items', 'ERP\ItemsController@index');
Route::get('/items/create', 'ERP\ItemsController@create');
Route::post('/items/create', 'ERP\ItemsController@postCreate');
Route::get('/items/edit/{slug}', 'ERP\ItemsController@edit');
Route::post('/items/edit/{slug}', 'ERP\ItemsController@update');




/* Start employee */
Route::get('/employee', 'POS\EmployeeController@index');

Route::get('/employee/create', 'POS\EmployeeController@create');
Route::post('/employee/create', 'POS\EmployeeController@postcreate');

Route::get('/employee/details/{id}', 'POS\EmployeeController@details');

Route::get('/employee/edit/{id}', 'POS\EmployeeController@edit');
Route::get('/employee/track/{id}', 'POS\EmployeeController@track');
Route::post('/employee/edit', 'POS\EmployeeController@postedit');

Route::get('/employee/delete/{id}', 'POS\EmployeeController@delete');
Route::post('/employee/Partialdelete', 'POS\EmployeeController@ajaxPartdelete');
Route::post('/employee/Completedelete', 'POS\EmployeeController@ajaxCompdelete');

Route::post('/employee/punch', 'POS\PunchController@ajaxPunchEmployee');
/* End employee */

Route::get('/addon/rfid/request', 'Addons\Rfid\RfidRequestController@index');
Route::post('/addon/rfid/request', 'Addons\Rfid\RfidRequestController@create');
Route::post('/addon/rfid/checkRequest', 'Addons\Rfid\RfidRequestController@checkTableRequest');

Route::get('/addon/rfid/table', 'Addons\Rfid\RfidTableController@index');
Route::get('/addon/rfid/table/{slug}', 'Addons\Rfid\RfidTableController@edit');
Route::post('/addon/rfid/table/{slug}', 'Addons\Rfid\RfidTableController@update');
Route::post('/addon/rfid/beers', 'Addons\Rfid\RfidTableController@getBeers');

/* Start schedule */
Route::get('/schedule', 'POS\ScheduleController@index');

Route::get('/schedule/create', 'POS\ScheduleController@create');
Route::post('/schedule/create', 'POS\ScheduleController@postcreate');

Route::get('/schedule/edit/{id}', 'POS\ScheduleController@edit');
Route::post('/schedule/edit', 'POS\ScheduleController@postedit');

Route::get('/schedule/delete/{id}', 'POS\ScheduleController@delete');
Route::delete('/schedule/deleteArch/{id}', 'POS\ScheduleController@deleteArch');
Route::delete('/schedule/deleteComp/{id}', 'POS\ScheduleController@deleteComp');

Route::get('/schedule/view/{id}', 'POS\ScheduleController@details');
Route::get('/schedule/track/{id}', 'POS\ScheduleController@track');

Route::post('/schedule/AjaxFindDispos', 'POS\ScheduleController@AjaxFindDispos');
Route::post('/schedule/AjaxGetEmployeeDaySchedules', 'POS\ScheduleController@AjaxGetEmployeeDaySchedules');

/* End schedule */

/* Start Punch */
Route::get('/punch', 'POS\PunchController@index');
/* End Punch */

/* Start disponibility */
Route::get('/disponibility', 'POS\DisponibilityController@index');

Route::get('/disponibility/create', 'POS\DisponibilityController@create');
Route::post('/disponibility/create', 'POS\DisponibilityController@postcreate');

Route::get('/disponibility/edit/{id}', 'POS\DisponibilityController@edit');
Route::post('/disponibility/edit', 'POS\DisponibilityController@postedit');

Route::get('/disponibility/delete/{id}', 'POS\DisponibilityController@delete');
Route::delete('/disponibility/deleteArch/{id}', 'POS\DisponibilityController@deleteArch');
Route::delete('/disponibility/deleteComp/{id}', 'POS\DisponibilityController@deleteComp');

Route::get('/disponibility/view/{id}', 'POS\DisponibilityController@details');
/* End disponibility */

/* Start Punch */

/* End Punch */

