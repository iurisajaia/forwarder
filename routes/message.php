<?php

use App\Http\Controllers\Api\MessageController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'message'], function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/create', [MessageController::class , 'create']);
    });
});

