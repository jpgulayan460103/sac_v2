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

if(config('app.env') == "production"){
    $route_params = ['middleware' => 'auth:api'];
}else{
    $route_params = ['middleware' => 'auth:api'];
    // $route_params = [];
}
Route::group($route_params, function () {
    Route::get('household-heads', 'HouseholdHeadController@index')->name('api.household-head.index');
    Route::post('household-heads', 'HouseholdHeadController@store')->name('api.household-head.store');
    Route::put('household-heads/{id}', 'HouseholdHeadController@update')->name('api.household-head.update');
    Route::delete('household-heads/{id}', 'HouseholdHeadController@destroy')->name('api.household-head.destroy');
    Route::post('export/household-heads/create', 'HouseholdHeadController@createExport')->name('api.household-head.createExport');
    Route::post('export/household-heads/write', 'HouseholdHeadController@writeExport')->name('api.household-head.writeExport');
    Route::post('logout', 'AuthController@logout')->name('api.auth.logout');
    Route::get('users', 'UserController@index')->name('api.user.index');
    Route::post('users/active-status/{id}', 'UserController@activeStatus')->name('api.user.active-status');
    Route::post('users/role-status/{id}', 'UserController@roleStatus')->name('api.user.role-status');
    Route::put('users/{id}', 'UserController@update')->name('api.user.update');
    Route::get('autocompletes/trabahos', 'HouseholdHeadController@listTrabaho')->name('api.user.update');
});
Route::get('provinces', 'BarangayController@listProvinces')->name('api.barangay.province');
Route::get('provinces/{city_psgc}/cities', 'BarangayController@listCities')->name('api.barangay.city');
Route::get('provinces/{city_psgc}/cities/{barangay_psgc}/barangays', 'BarangayController@listBarangays')->name('api.barangay.barangay');
Route::post('users', 'UserController@store')->name('api.user.store');
Route::post('login', 'AuthController@login')->name('api.auth.login');
Route::get('test', 'HouseholdHeadController@export')->name('api.test');

Route::get('reports/encoding/barangay', 'ReportController@encodingBarangay')->name('api.report.encoding.barangay');
Route::get('reports/encoding/province', 'ReportController@encodingProvince')->name('api.report.encoding.province');
Route::get('reports/encoding/city', 'ReportController@encodingCity')->name('api.report.encoding.city');
