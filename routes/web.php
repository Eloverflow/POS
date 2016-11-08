<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/search', ['uses' => 'SearchController@search', 'middleware' => 'auth']);

Route::get('/website', ['uses' => 'PagesController@websiteLayout', 'middleware' => 'auth']);
Route::get('/posio-menu', ['uses' => 'PagesController@posioMenu']);

Route::get('/user/password/update', ['uses' => 'Auth\UserController@update','middleware' => 'auth']);
Route::post('/user/password/update', ['uses' => 'Auth\UserController@updatePassword','middleware' => 'auth']);
Route::get('/password/email', ['uses' => 'Auth\UserController@forgotPass']);

Route::get('/activity-log',  ['uses' => 'ERP\ActivityLogController@index', 'middleware' => 'auth']);
Route::get('/activity-log/over/{id}',  ['uses' => 'ERP\ActivityLogController@overId', 'middleware' => 'auth']);
Route::get('/activity-log/olderthan/{id}',  ['uses' => 'ERP\ActivityLogController@olderThan', 'middleware' => 'auth']);
Route::get('/activity-log/list',  ['uses' => 'ERP\ActivityLogController@liste', 'middleware' => 'auth']);

Route::get('/',  ['uses' => 'PagesController@index', 'middleware' => 'auth']);
Route::get('/about',  ['uses' => 'PagesController@about', 'middleware' => 'auth']);
Route::get('/contact',  ['uses' => 'PagesController@contact', 'middleware' => 'auth']);


Route::get('/sales',  ['uses' => 'POS\SalesController@index', 'middleware' => 'auth']);
Route::get('/sales/list',  ['uses' => 'POS\SalesController@liste', 'middleware' => 'auth']);
Route::get('/menu',  ['uses' => 'POS\SalesController@menu', 'middleware' => 'auth']);
Route::get('/menu-settings',  ['uses' => 'POS\SalesController@menuSettings', 'middleware' => 'auth']);
Route::post('/menu-settings',  ['uses' => 'POS\SalesController@applyMenuSettings', 'middleware' => 'auth']);

/*Route::get('/menu/start',  ['uses' => 'POS\SalesController@menuStart', 'middleware' => 'auth']);
Route::post('/menu/payer',  ['uses' => 'POS\SalesController@payer', 'middleware' => 'auth']);*/


Route::get('/inventory',  ['uses' => 'ERP\InventoriesController@index', 'middleware' => 'auth']);
Route::get('/inventory/edit/{slug}',  ['uses' => 'ERP\InventoriesController@edit', 'middleware' => 'auth']);
Route::get('/inventory/details/{slug}',  ['uses' => 'ERP\InventoriesController@details', 'middleware' => 'auth']);
Route::post('/inventory/edit/{slug}',  ['uses' => 'ERP\InventoriesController@postEdit', 'middleware' => 'auth']);
Route::get('/inventory/create',  ['uses' => 'ERP\InventoriesController@create', 'middleware' => 'auth']);
Route::post('/inventory/create',  ['uses' => 'ERP\InventoriesController@postCreate', 'middleware' => 'auth']);

Route::get('/itemtypes',  ['uses' => 'ERP\ItemTypesController@index', 'middleware' => 'auth']);
Route::get('/itemtypes/edit/{slug}',  ['uses' => 'ERP\ItemTypesController@edit', 'middleware' => 'auth']);
Route::post('/itemtypes/edit/{slug}',  ['uses' => 'ERP\ItemTypesController@update', 'middleware' => 'auth']);

Route::post('/item/type/create',  ['uses' => 'ERP\ItemTypesController@postCreate', 'middleware' => 'auth']);

Route::get('/items',  ['uses' => 'ERP\ItemsController@index', 'middleware' => 'auth']);
Route::get('/items/create',  ['uses' => 'ERP\ItemsController@create', 'middleware' => 'auth']);
Route::post('/items/create',  ['uses' => 'ERP\ItemsController@postCreate', 'middleware' => 'auth']);
Route::get('/items/details/{slug}',  ['uses' => 'ERP\ItemsController@details', 'middleware' => 'auth']);
Route::get('/items/edit/{slug}',  ['uses' => 'ERP\ItemsController@edit', 'middleware' => 'auth']);
Route::post('/items/edit/{slug}',  ['uses' => 'ERP\ItemsController@postEdit', 'middleware' => 'auth']);

Route::get('/extras',  ['uses' => 'ERP\ExtrasController@index', 'middleware' => 'auth']);
Route::get('/extras/create',  ['uses' => 'ERP\ExtrasController@create', 'middleware' => 'auth']);
Route::post('/extras/create',  ['uses' => 'ERP\ExtrasController@postCreate', 'middleware' => 'auth']);

Route::get('/extras/edit/{slug}',  ['uses' => 'ERP\ExtrasController@edit', 'middleware' => 'auth']);
Route::post('/extras/edit/{slug}',  ['uses' => 'ERP\ExtrasController@update', 'middleware' => 'auth']);

Route::get('/filters',  ['uses' => 'POS\FiltersController@index', 'middleware' => 'auth']);
Route::get('/filters/create',  ['uses' => 'POS\FiltersController@create', 'middleware' => 'auth']);
Route::post('/filters/create',  ['uses' => 'POS\FiltersController@postCreate', 'middleware' => 'auth']);

Route::get('/filters/edit/{slug}',  ['uses' => 'POS\FiltersController@edit', 'middleware' => 'auth']);
Route::post('/filters/edit/{slug}',  ['uses' => 'POS\FiltersController@update', 'middleware' => 'auth']);

Route::get('/clients',  ['uses' => 'POS\ClientController@index', 'middleware' => 'auth']);
Route::get('/clients/create',  ['uses' => 'POS\ClientController@create', 'middleware' => 'auth']);
Route::get('/clients/details/{slug}',  ['uses' => 'POS\ClientController@details', 'middleware' => 'auth']);
Route::post('/clients/create',  ['uses' => 'POS\ClientController@postCreate', 'middleware' => 'auth']);
Route::get('/clients/edit/{slug}',  ['uses' => 'POS\ClientController@edit', 'middleware' => 'auth']);
Route::post('/clients/edit/{slug}',  ['uses' => 'POS\ClientController@postEdit', 'middleware' => 'auth']);

/* Start employee */
Route::get('/employee',  ['uses' => 'POS\EmployeeController@index', 'middleware' => 'auth']);

Route::get('/employee/create',  ['uses' => 'POS\EmployeeController@create', 'middleware' => 'auth']);
Route::post('/employee/create',  ['uses' => 'POS\EmployeeController@postcreate', 'middleware' => 'auth']);

Route::get('/employee/details/{id}',  ['uses' => 'POS\EmployeeController@details', 'middleware' => 'auth']);

Route::get('/work/titles',  ['uses' => 'POS\WorkTitleController@index', 'middleware' => 'auth']);
Route::post('/work/title/create',  ['uses' => 'POS\WorkTitleController@postCreate', 'middleware' => 'auth']);
Route::post('/work/title/edit',  ['uses' => 'POS\WorkTitleController@postEdit', 'middleware' => 'auth']);
Route::post('/work/title/add/employee',  ['uses' => 'POS\WorkTitleController@addEmployee', 'middleware' => 'auth']);
Route::delete('/work/title/del/employee',  ['uses' => 'POS\WorkTitleController@delEmployee', 'middleware' => 'auth']);


Route::get('/employee/edit/{id}',  ['uses' => 'POS\EmployeeController@edit', 'middleware' => 'auth']);
Route::get('/employee/track/{id}',  ['uses' => 'POS\EmployeeController@track', 'middleware' => 'auth']);
Route::post('/employee/edit',  ['uses' => 'POS\EmployeeController@postedit', 'middleware' => 'auth']);

Route::get('/employee/delete/{id}',  ['uses' => 'POS\EmployeeController@delete', 'middleware' => 'auth']);
Route::post('/employee/Partialdelete',  ['uses' => 'POS\EmployeeController@ajaxPartdelete', 'middleware' => 'auth']);
Route::post('/employee/Completedelete',  ['uses' => 'POS\EmployeeController@ajaxCompdelete', 'middleware' => 'auth']);

/* End employee */

Route::get('/addon/rfid/request',  ['uses' => 'Addons\Rfid\RfidRequestController@index', 'middleware' => 'auth']);
Route::post('/addon/rfid/request',  ['uses' => 'Addons\Rfid\RfidRequestController@create', 'middleware' => 'auth']);
Route::post('/addon/rfid/checkRequest',  ['uses' => 'Addons\Rfid\RfidRequestController@checkTableRequest', 'middleware' => 'auth']);

Route::get('/addon/rfid/table',  ['uses' => 'Addons\Rfid\RfidTableController@index', 'middleware' => 'auth']);
Route::get('/addon/rfid/table/edit/{slug}',  ['uses' => 'Addons\Rfid\RfidTableController@edit', 'middleware' => 'auth']);
Route::post('/addon/rfid/table/edit/{slug}',  ['uses' => 'Addons\Rfid\RfidTableController@update', 'middleware' => 'auth']);
Route::post('/addon/rfid/beers',  ['uses' => 'Addons\Rfid\RfidTableController@getBeers', 'middleware' => 'auth']);

/* Start schedule */
Route::get('/schedule',  ['uses' => 'POS\ScheduleController@index', 'middleware' => 'auth']);

Route::get('/schedule/create',  ['uses' => 'POS\ScheduleController@create', 'middleware' => 'auth']);
Route::post('/schedule/create',  ['uses' => 'POS\ScheduleController@postcreate', 'middleware' => 'auth']);

Route::get('/schedule/edit/{id}',  ['uses' => 'POS\ScheduleController@edit', 'middleware' => 'auth']);
Route::post('/schedule/edit',  ['uses' => 'POS\ScheduleController@postedit', 'middleware' => 'auth']);

Route::get('/schedule/{scheduleid}/employees',  ['uses' => 'POS\ScheduleController@employeesSchedule', 'middleware' => 'auth']);
Route::get('/schedule/{scheduleid}/employee/{employeeid}', ['uses' => 'POS\ScheduleController@employeeSchedule', 'middleware' => 'auth']);

Route::get('/schedule/delete/{id}',  ['uses' => 'POS\ScheduleController@delete', 'middleware' => 'auth']);
Route::delete('/schedule/deleteArch/{id}',  ['uses' => 'POS\ScheduleController@deleteArch', 'middleware' => 'auth']);
Route::delete('/schedule/deleteComp/{id}',  ['uses' => 'POS\ScheduleController@deleteComp', 'middleware' => 'auth']);

Route::get('/schedule/{scheduleid}/pdf',  ['uses' => 'POS\ScheduleController@GetSchedulePDF', 'middleware' => 'auth']);
Route::get('/schedule/{scheduleid}/employee/{employeeid}/pdf',  ['uses' => 'POS\ScheduleController@GetScheduleForEmployeePDF', 'middleware' => 'auth']);

Route::get('/schedule/details/{id}',  ['uses' => 'POS\ScheduleController@details', 'middleware' => 'auth']);

Route::get('/schedule/track/{id}',  ['uses' => 'POS\ScheduleController@track', 'middleware' => 'auth']);

Route::post('/schedule/AjaxFindDispos',  ['uses' => 'POS\ScheduleController@AjaxFindDispos', 'middleware' => 'auth']);
Route::post('/schedule/AjaxGetEmployeeDaySchedules',  ['uses' => 'POS\ScheduleController@AjaxGetEmployeeDaySchedules', 'middleware' => 'auth']);

/* End schedule */



/* Start Punch */
/*Route::get('/punch',  ['uses' => 'POS\PunchController@index', 'middleware' => 'auth']);*/
/*Route::get('/keyboard',  ['uses' => 'POS\PunchController@keyboard', 'middleware' => 'auth']);*/
/* End Punch */

/* Start Plan */
Route::get('/plan',  ['uses' => 'POS\PlanController@index', 'middleware' => 'auth']);
Route::get('/plan/create/{planName}/{nbFloor}',  ['uses' => 'POS\PlanController@create', 'middleware' => 'auth']);
Route::post('/plan/create',  ['uses' => 'POS\PlanController@postCreate', 'middleware' => 'auth']);

Route::get('/plan/edit/{id}',  ['uses' => 'POS\PlanController@edit', 'middleware' => 'auth']);
Route::post('/plan/edit/{id}',  ['uses' => 'POS\PlanController@postEdit', 'middleware' => 'auth']);

Route::get('/plan/details/{id}',  ['uses' => 'POS\PlanController@details', 'middleware' => 'auth']);
/* End Plan */

/* Start availability */
Route::get('/availability',  ['uses' => 'POS\AvailabilityController@index', 'middleware' => 'auth']);

Route::get('/availability/create',  ['uses' => 'POS\AvailabilityController@create', 'middleware' => 'auth']);
Route::post('/availability/create',  ['uses' => 'POS\AvailabilityController@postCreate', 'middleware' => 'auth']);

Route::get('/availability/edit/{id}',  ['uses' => 'POS\AvailabilityController@edit', 'middleware' => 'auth']);
Route::post('/availability/edit',  ['uses' => 'POS\AvailabilityController@postedit', 'middleware' => 'auth']);

Route::get('/availability/delete/{id}',  ['uses' => 'POS\AvailabilityController@delete', 'middleware' => 'auth']);
Route::delete('/availability/deleteArch/{id}',  ['uses' => 'POS\AvailabilityController@deleteArch', 'middleware' => 'auth']);
Route::delete('/availability/deleteComp/{id}',  ['uses' => 'POS\AvailabilityController@deleteComp', 'middleware' => 'auth']);

Route::get('/availability/details/{id}',  ['uses' => 'POS\AvailabilityController@details', 'middleware' => 'auth']);
/* End availability */

/* Start Punch */

/* End Punch */

/*  Start Statistics */
Route::get('/stats',  ['uses' => 'POS\StatsController@index', 'middleware' => 'auth']);

/* End Statistics */

/* Start Calendar */
Route::get('/calendar',  ['uses' => 'POS\CalendarController@index', 'middleware' => 'auth']);
Route::get('/calendar/edit',  ['uses' => 'POS\CalendarController@edit', 'middleware' => 'auth']);
Route::post('/calendar/edit',  ['uses' => 'POS\CalendarController@postedit', 'middleware' => 'auth']);
/* End Calendar */
