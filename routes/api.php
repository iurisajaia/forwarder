<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarTypeController;
use App\Http\Controllers\Api\RsController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'createUser']);
    Route::post('/verify', [AuthController::class, 'verifyUser']);
    Route::post('/get-login-code', [AuthController::class, 'getLoginCode']);
    Route::post('/login', [AuthController::class, 'loginUser']);
    Route::get('/users', [AuthController::class, 'getUsers']);
    Route::get('/user-roles', [AuthController::class, 'getUserRoles']);
});

Route::get('/car-types', [CarTypeController::class , 'index'])->name('car-types');

Route::group(['prefix' => 'rs'], function () {
    Route::get('/tax-payer/{code}' , [RsController::class , 'taxPayer']);
});
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/user', [AuthController::class , 'currentUser']);
});

