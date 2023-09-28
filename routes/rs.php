<?php

use App\Http\Controllers\Api\RsController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'rs'], function () {
    Route::get('/tax-payer/{code}' , [RsController::class , 'taxPayer']);
});


