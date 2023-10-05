<?php

use App\Http\Controllers\Api\TrailerController;
use App\Http\Controllers\Api\TrailerTypeController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum','prefix' => 'trailer'], function () {
    Route::post('/create' , [TrailerController::class , 'create']);
    Route::get('/types', [TrailerTypeController::class , 'index']);
    Route::post('/make-it-default/{id}', [TrailerController::class , 'makeItDefault']);
});


