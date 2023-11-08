<?php

use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\CityController;
use Illuminate\Support\Facades\Route;




Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'image', 'as' => 'image'], function(){
    Route::post('/delete', [ImageController::class, 'delete'] );
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'city', 'as' => 'city'], function(){
    Route::get('/', [CityController::class, 'index'] );
});
