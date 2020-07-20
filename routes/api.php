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
Route::prefix('v1')->group(function () {
    Route::post('login', 'AuthController@login');
    
    Route::middleware('jwt.auth')->group(function () {
        Route::get('user', 'AuthController@user');
	
	Route::get('employees','EmployeesController@index');
        Route::get('employees/{id}','EmployeesController@employee');
        Route::post('employees','EmployeesController@create');
        Route::put('employees/{id}','EmployeesController@update');
        Route::delete('employees/{id}','EmployeesController@delete');
    });
});
