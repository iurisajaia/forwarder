<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarTypeController;
use Illuminate\Http\Request;
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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
