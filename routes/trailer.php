<?php

use App\Http\Controllers\Api\TrailerController;
use App\Http\Controllers\Api\TrailerTypeController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'trailer'], function () {
    Route::post('/create' , [TrailerController::class , 'create']);
    Route::get('/types', [TrailerTypeController::class , 'index']);
});


