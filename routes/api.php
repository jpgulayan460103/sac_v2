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
Route::post('household-heads', 'HouseholdHeadController@store')->name('api.household-head.store');
Route::get('provinces', 'BarangayController@listProvinces')->name('api.household-head.store');
Route::get('provinces/{city_psgc}/cities', 'BarangayController@listCities')->name('api.household-head.store');
Route::get('provinces/{city_psgc}/cities/{barangay_psgc}/barangays', 'BarangayController@listBarangays')->name('api.household-head.store');
