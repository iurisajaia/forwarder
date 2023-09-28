<?php

use App\Http\Controllers\Api\DealController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'deal'], function(){
        Route::get('/', [DealController::class , 'index']);
    });
});





