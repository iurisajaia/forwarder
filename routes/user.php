<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'user'], function () {
    Route::post('/create', [UserController::class, 'create']);

    Route::delete('/delete/{id}', [UserController::class, 'delete']);
    Route::get('/roles', [UserController::class, 'roles']);

    Route::post('/verify', [UserController::class, 'verify']);
    Route::post('/get-login-code', [UserController::class, 'getLoginCode']);
    Route::post('/login', [UserController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function(){
        Route::get('/', [UserController::class , 'currentUser']);
        Route::put('/update', [UserController::class, 'update']);
        Route::put('/driver-freedom', [UserController::class, 'updateDriverFreeTime']);
        Route::group(['middleware' => 'role:forwarder,transport_company'], function (){
            Route::post('/add-driver' , [UserController::class , 'addDriver']);
        });
    });

});


