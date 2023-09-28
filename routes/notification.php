<?php

use App\Http\Controllers\Api\DealController;

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'notification'], function() {
        Route::get('/', [DealController::class , 'notifications']);
        Route::post('/{id}', [DealController::class , 'acceptNotification']);
    });
});





