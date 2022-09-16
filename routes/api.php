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
        "status"    => 200,
        "message"   => "we are alive",
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'middleware'    => ['api'],
    'namespace'     => 'App\Http\Controllers',
], function ($router) {
    Route::post('auth/login', 'AuthController@login');
});

Route::group([
    'middleware'    => ['api', 'auth'],
    'namespace'     => 'App\Http\Controllers',
], function ($router) {

    Route::group([
        'prefix' => 'auth'
    ], function () {

        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');
    });

    Route::resource('user', 'UserController');

    Route::resource('roles', 'RoleController');
    Route::get('permissions' , 'RoleController@permissions');
    Route::post('assign-permission', 'RoleController@assignPermission');
    Route::post('remove-permission', 'RoleController@removePermission');
    Route::post('assign-role', 'RoleController@assignRole');


    Route::resource('city', 'CityController');

    Route::resource('zone', 'ZoneController');

    Route::resource('merchant', 'MerchantController');

    Route::resource('order', 'OrderController');
    Route::get('parcel-order/{parcel_order_id}', 'OrderController@showParcelOrder');
    Route::put('parcel-order/{parcel_order_id}', 'OrderController@updateParcelOrder');
    Route::delete('parcel-order/{parcel_order_id}', 'OrderController@destroyParcelOrder');
    Route::put('parcel/{parcel_id}', 'OrderController@updateParcel');
    Route::delete('parcel/{parcel_id}', 'OrderController@destroyParcel');
    Route::put('order-status/{order_id}', 'OrderController@updateOrderStatus');
    Route::put('parcel-order-status/{parcel_order_id}', 'OrderController@updateParcelOrderStatus');
    Route::put('parcel-status/{parcel_id}', 'OrderController@updateParcelStatus');
    Route::put('update-order-data/{order_id}', 'OrderController@updateOrderData');
});
