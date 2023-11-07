<?php

use App\Http\Controllers\Api\ImageController;
use Illuminate\Support\Facades\Route;




Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'image', 'as' => 'image'], function(){
    Route::post('/delete', [ImageController::class, 'delete'] );
});
