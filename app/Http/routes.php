

<?php

use App\Models\EventCustom;
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


Route::get('/keyboard', 'POS\CommandController@keyboard');
Route::get('/mainmenu', 'POS\CommandController@mainmenu');


Route::get('/sales', 'POS\SalesController@index');
Route::get('/sales/list', 'POS\SalesController@liste');
Route::get('/menu', 'POS\SalesController@menu');
Route::post('/menu/payer', 'POS\SalesController@payer');
Route::post('/menu/command', 'POS\SalesController@updateCommand');

Route::get('/inventory', 'ERP\InventoriesController@index');
Route::get('/inventory/edit',  function() { return Redirect::to('/inventory');});
Route::get('/inventory/edit/{slug}', 'ERP\InventoriesController@edit');
Route::get('/inventory/view',  function() { return Redirect::to('/inventory');});
Route::get('/inventory/view/{slug}', 'ERP\InventoriesController@details');
Route::post('/inventory/edit/{slug}', 'ERP\InventoriesController@update');
Route::get('/inventory/create', 'ERP\InventoriesController@create');
Route::post('/inventory/create', 'ERP\InventoriesController@postCreate');



Route::get('/itemtypes', 'ERP\ItemTypesController@index');
Route::get('/itemtypes/list', 'ERP\ItemTypesController@liste');
Route::get('/itemtypes/edit/{slug}', 'ERP\ItemTypesController@edit');
Route::post('/itemtypes/edit/{slug}', 'ERP\ItemTypesController@update');

Route::get('/items', 'ERP\ItemsController@index');
Route::get('/items/create', 'ERP\ItemsController@create');
Route::post('/items/create', 'ERP\ItemsController@postCreate');
Route::get('/items/edit/{slug}', 'ERP\ItemsController@edit');
Route::post('/items/edit/{slug}', 'ERP\ItemsController@update');
Route::get('/items/liste', 'ERP\ItemsController@liste');

Route::get('/calendar',  function() {
    /*
        $events = [];*/

    $event = \Calendar::event(
        "Jean - 2016-03-09 to 2016-03-11 ", //event title
        false, //full day event?
        '21:30', //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
        '23:40', //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
        1, //optional event ID
        [
            'url' => 'http://full-calendar.io',
            //any other full-calendar supported parameters
        ]
    );

    $calendar = \Calendar::addEvent($event);

    return view('calendar', compact('calendar'));
});

Route::get('/clients', 'POS\ClientController@index');
Route::get('/clients/create', 'POS\ClientController@create');
Route::post('/clients/create', 'POS\ClientController@postCreate');
Route::get('/clients/edit/{slug}', 'POS\ClientController@edit');
Route::post('/clients/edit/{slug}', 'POS\ClientController@update');

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
Route::post('/schedule/create', 'POS\ScheduleController@postCreate');

Route::get('/schedule/edit/{id}', 'POS\ScheduleController@edit');
Route::post('/schedule/edit', 'POS\ScheduleController@postEdit');

Route::get('/schedule/{scheduleid}/employees', 'POS\ScheduleController@employeesSchedule');
Route::get('/schedule/{scheduleid}/employee/{employeeid}', 'POS\ScheduleController@employeeSchedule');

Route::get('/schedule/delete/{id}', 'POS\ScheduleController@delete');
Route::delete('/schedule/deleteArch/{id}', 'POS\ScheduleController@deleteArch');
Route::delete('/schedule/deleteComp/{id}', 'POS\ScheduleController@deleteComp');

Route::get('/schedule/{scheduleid}/pdf', 'POS\ScheduleController@GetSchedulePDF');
Route::get('/schedule/{scheduleid}/employee/{employeeid}/pdf', 'POS\ScheduleController@GetScheduleForEmployeePDF');

Route::get('/schedule/details/{id}', 'POS\ScheduleController@details');

Route::post('/schedule/AjaxFindDispos', 'POS\ScheduleController@AjaxFindDispos');
Route::post('/schedule/AjaxGetEmployeeDaySchedules', 'POS\ScheduleController@AjaxGetEmployeeDaySchedules');

/* End schedule */

/* Start Punch */
Route::get('/punch', 'POS\PunchController@index');
Route::get('/punch/tables', 'POS\PunchController@tables');
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

Route::get('/disponibility/details/{id}', 'POS\DisponibilityController@details');
/* End disponibility */

/* Start Punch */

/* End Punch */

