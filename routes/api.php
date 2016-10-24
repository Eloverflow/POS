<?php

use Illuminate\Http\Request;

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

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');*/


Route::get('/itemtypes/list',  ['uses' => 'ERP\ItemTypesController@liste', 'middleware' => 'cors']);
Route::get('/work/titles/list',  ['uses' => 'POS\WorkTitleController@index', 'middleware' => 'cors']);
Route::get('/table-plan/{id}',  ['uses' => 'POS\PlanController@tablePlan', 'middleware' => 'cors']);
Route::get('/items/liste',  ['uses' => 'ERP\ItemsController@liste', 'middleware' => 'cors']);
Route::get('/filters/list',  ['uses' => 'POS\FiltersController@liste', 'middleware' => 'cors']);
Route::get('/extras/list',  ['uses' => 'ERP\ExtrasController@liste', 'middleware' => 'cors']);
Route::post('/employee/authenticate/{id}',  ['uses' => 'POS\EmployeeController@authenticateEmployee', 'middleware' => 'cors']);
