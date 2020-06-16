<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $string = "a--a-";
    dd( preg_match('/^[\pL\pM0-9]/u', $string) > 0 );
    // return redirect(config('services.ui.url'));
})->name('home');
Route::get('/login', function () {
    return redirect(config('services.ui.url'));
})->name('login');
