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
    return view('welcome');
});

Route::get('/admin', function () {
    return view('index');
});

Route::get('/teacher', function () {
    return view('index');
});

Route::get('/admin/{any}', function ($any) {
    return view('index');
})->where('any', '.*');

Route::get('/teacher/{any}', function ($any) {
    return view('index');
})->where('any', '.*');