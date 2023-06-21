<?php

use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CarTypeController;
use App\Http\Controllers\Api\RsController;
use App\Http\Controllers\Api\TrailerTypeController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\TrailerController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'user'], function () {
    Route::post('/create', [UserController::class, 'create']);
    Route::put('/update/{id}', [UserController::class, 'update']);
    Route::delete('/delete/{id}', [UserController::class, 'delete']);
    Route::get('/roles', [UserController::class, 'roles']);

    Route::post('/verify', [UserController::class, 'verify']);
    Route::post('/get-login-code', [UserController::class, 'getLoginCode']);
    Route::post('/login', [UserController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function(){
        Route::get('/', [UserController::class , 'currentUser']);
    });

});

Route::group(['prefix' => 'language'], function () {
    Route::get('/', [LanguageController::class , 'index']);
});

Route::group(['prefix' => 'car'], function () {
    Route::post('/create' , [CarController::class , 'create']);
    Route::get('/types', [CarTypeController::class , 'index']);
});

Route::group(['prefix' => 'trailer'], function () {
    Route::post('/create' , [TrailerController::class , 'create']);
    Route::get('/types', [TrailerTypeController::class , 'index']);
});




Route::group(['prefix' => 'rs'], function () {
    Route::get('/tax-payer/{code}' , [RsController::class , 'taxPayer']);
});


