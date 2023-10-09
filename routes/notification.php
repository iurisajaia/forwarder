<?php

use App\Http\Controllers\Api\NotificationController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'notification'], function () {
        Route::get('/', [NotificationController::class , 'index']);
});





