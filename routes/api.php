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
Route::post('login', 'AuthController@login')->name('api.auth.login');
Route::middleware('auth:api')->post('household-heads', 'HouseholdHeadController@store')->name('api.household-head.store');
Route::middleware('auth:api')->get('provinces', 'BarangayController@listProvinces')->name('api.household-head.store');
Route::middleware('auth:api')->get('provinces/{city_psgc}/cities', 'BarangayController@listCities')->name('api.household-head.store');
Route::middleware('auth:api')->get('provinces/{city_psgc}/cities/{barangay_psgc}/barangays', 'BarangayController@listBarangays')->name('api.household-head.store');
Route::post('logout', 'AuthController@logout')->name('api.auth.logout');
// Route::middleware('auth:api')->post('logout', 'AuthController@logout')->name('api.auth.logout');
