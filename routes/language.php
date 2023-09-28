<?php

use App\Http\Controllers\Api\LanguageController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'language'], function () {
    Route::get('/', [LanguageController::class , 'index']);
});

