<?php

use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CarTypeController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'car'], function () {
    Route::get('/types', [CarTypeController::class , 'index']);
    Route::group(['middleware' => ['auth:sanctum', 'role:driver,transport_company,forwarder']], function () {
        Route::post('/create', [CarController::class , 'create']);
        Route::post('/make-it-default/{id}', [CarController::class , 'makeItDefault']);
    });
});

