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

Route::get('/', function(){
    return response()->json([
        "status" => 200,
        "message" => "we are alive",
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => ['api', 'auth'],
    'namespace' => 'App\Http\Controllers',
], function ($router) {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');
    });



    Route::resource('roles', 'RoleController');
    Route::get('permissions' , 'RoleController@permissions');
    Route::post('assign-permission', 'RoleController@assignPermission');
    Route::post('assign-role', 'RoleController@assignRole');




});
