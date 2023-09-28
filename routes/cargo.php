<?php

use App\Http\Controllers\Api\CargoController;

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'cargo'], function(){
        Route::get('/', [CargoController::class , 'index']);
        Route::post('/', [CargoController::class , 'create']);
    });
});





