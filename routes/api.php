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

Route::post('reset-password', 'ResetPasswordController@sendPasswordResetLink');
Route::post('/measuring','MeasurementController@store');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('me','Auth\MeController');
    Route::get('dashboard','DashboardController@index');
    Route::get('sparing','MeasurementController@index');
    Route::get('report','ReportController@index');
    Route::get('report/export','ReportController@export');
    Route::post('/profile/update','UsersController@update');
});
