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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/desktop','DesktopController@show');
Route::post('/cmd','CmdController@index');
Route::post('/init','CmdController@init');
Route::post('/login','LoginController@login');
Route::get('/getFile','FileController@getFile');
Route::get('/searchFile','FileController@searchFile');
Route::get('/getContent','EditorController@getContent');
Route::post('/saveContent','EditorController@saveContent');

