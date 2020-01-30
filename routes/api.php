<?php

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


Route::get('/users', 'CmsUsersController@index');
Route::delete('/users/{user_id}', 'CmsUsersController@destroy');
Route::post('/users', 'CmsUsersController@create');
Route::patch('/users/{user_id}', 'CmsUsersController@update');



Route::get('/usergroups', 'CmsUserGroupController@index');
