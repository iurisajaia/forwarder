<?php

use App\Http\Controllers\Api\TrailerController;
use App\Http\Controllers\Api\TrailerTypeController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'trailer'], function () {
    Route::get('/types', [TrailerTypeController::class , 'index']);
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/create', [TrailerController::class , 'create']);
        Route::post('/make-it-default/{id}', [TrailerController::class , 'makeItDefault']);
    });
});


