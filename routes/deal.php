<?php

use App\Http\Controllers\Api\DealController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'deal', 'middleware' => ['role:forwarder,legal,transport_company,driver']], function(){
        Route::get('/', [DealController::class , 'index']);
        Route::post('/finish/{id}', [DealController::class , 'finishDeal']);
    });
    Route::group(['prefix' => 'deal', 'middleware' => ['role:driver']], function(){
        Route::post('/complete/{id}', [DealController::class , 'completeDeal']);
    });

    Route::group(['prefix' => 'offer'], function(){
        Route::post('/make', [DealController::class , 'makeOffer']);
    });
    Route::group(['prefix' => 'offer'], function(){
        Route::post('/reject/{id}', [DealController::class , 'rejectOffer']);
        Route::post('/accept/{id}', [DealController::class , 'acceptOffer']);
    });
    Route::group(['prefix' => 'currency'], function(){
        Route::get('/', [DealController::class , 'getCurrencies']);
    });
});





