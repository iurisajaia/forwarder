<?php

use App\Http\Controllers\Api\Chat\MessageController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'chat'], function(){
    Route::get('/show/{senderId}/{receiverId}', [MessageController::class , 'show']);
    Route::get('/{senderId}', [MessageController::class , 'index']);
    Route::post('/', [MessageController::class , 'sendMessage']);
});
