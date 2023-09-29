<?php

use App\Http\Controllers\Api\CargoController;

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'cargo'], function () {
        Route::get('/', [CargoController::class , 'index']);

        Route::group(['middleware' => ['role:standard']], function () {
            Route::post('/', [CargoController::class , 'create']);
        });
});





