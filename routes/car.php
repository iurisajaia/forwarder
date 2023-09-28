<?php

use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CarTypeController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'car'], function () {
    Route::post('/create' , [CarController::class , 'create']);
    Route::get('/types', [CarTypeController::class , 'index']);
});


