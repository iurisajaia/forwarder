<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'createUser']);
    Route::post('/verify', [AuthController::class, 'verifyUser']);
    Route::post('/get-login-code', [AuthController::class, 'getLoginCode']);
    Route::post('/login', [AuthController::class, 'loginUser']);
    Route::get('/users', [AuthController::class, 'getUsers']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
