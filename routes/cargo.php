<?php

use App\Http\Controllers\Api\CargoController;

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'cargo'], function () {
        Route::get('/', [CargoController::class , 'index']);
        Route::get('/danger-statuses', [CargoController::class , 'getDangerStatuses']);
        Route::get('/packaging-types', [CargoController::class , 'getPackagingTypes']);

//        Route::group(['middleware' => ['role:standard']], function () {
            Route::post('/', [CargoController::class , 'create']);
//        });
});





