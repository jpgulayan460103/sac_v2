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
    Route::get('provinces', 'BarangayController@listProvinces')->name('api.household-head.store');
    Route::get('provinces/{city_psgc}/cities', 'BarangayController@listCities')->name('api.household-head.store');
    Route::get('provinces/{city_psgc}/cities/{barangay_psgc}/barangays', 'BarangayController@listBarangays')->name('api.household-head.store');
    Route::post('logout', 'AuthController@logout')->name('api.auth.logout');
    Route::post('users', 'Usercontroller@store')->name('api.user.store');
    Route::get('users', 'UserController@index')->name('api.user.index');
    Route::post('users/active-status/{id}', 'Usercontroller@activeStatus')->name('api.user.active-status');
});
Route::post('login', 'AuthController@login')->name('api.auth.login');
