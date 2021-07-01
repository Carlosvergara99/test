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

Route::group([ 'middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register', 'AuthController@register');
    Route::post('permissson', 'AuthController@getPrmissions');

});
Route::group([ 'middleware' => 'api','prefix' => 'users',], function () {
    Route::get('get', 'UsersController@getUsers');

    Route::post('update', 'UsersController@UpdateUsers')->middleware('role:Admin');
    Route::post('delete', 'UsersController@destroy')->middleware('role:Admin');

});
Route::group([ 'middleware' => 'api','prefix' => 'client'], function ($router) {
    Route::get('get', 'ClientController@getClient');
    Route::post('store', 'ClientController@StoreClient');
    Route::post('update', 'ClientController@UpdateClient');
    Route::post('delete', 'ClientController@destroy');

});