<?php

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

// Only verified email can login to the admin
Auth::routes(['verify' => true]);

Route::get('/admin', 'HomeController@index')->name('admin')->middleware('verified');
