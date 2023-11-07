<?php

use App\Http\Controllers\Api\DriverController;

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'driver'], function () {
    Route::group(['middleware' => ['role:transport_company,forwarder']], function () {
        Route::post('/create', [DriverController::class , 'create']);
        Route::post('/update', [DriverController::class , 'update']);

        Route::post('/make-car-default/{id}', [DriverController::class , 'makeCarDefault']);
        Route::post('/make-trailer-default/{id}', [DriverController::class , 'makeTrailerDefault']);
        Route::post('/make-driver-default/{id}', [DriverController::class , 'makeDriverDefault']);

        Route::get('/my-drivers', [DriverController::class , 'getMyDrivers']);
        Route::get('/my-cars', [DriverController::class , 'getMyCars']);
        Route::get('/my-trailers', [DriverController::class , 'getMyTrailers']);
//        Route::post('/update/{id}', [DriverController::class , 'update']);
    });
});
