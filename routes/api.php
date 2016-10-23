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


Route::get('/itemtypes/list',  ['uses' => 'ERP\ItemTypesController@liste', 'middleware' => 'auth']);
Route::get('/work/titles/list',  ['uses' => 'POS\WorkTitleController@index', 'middleware' => 'auth']);
Route::get('/api/table-plan/{id}',  ['uses' => 'POS\PlanController@tablePlan']);