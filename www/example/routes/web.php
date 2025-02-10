<?php

use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/v1/'], function () {
    Route::get('',function (){
        return response()->json(['server'=>'up']);
    });

    Route::group(['prefix' => 'orders/'], function () {
        Route::get('', [OrderController::class, 'index']);
        Route::get('customer/{customerId}', [OrderController::class, 'getOrdersByCustomerId']);
        Route::get('{orderId}', [OrderController::class, 'show']);
        Route::delete('{orderId}', [OrderController::class, 'delete']);
        Route::put('{orderId}', [OrderController::class, 'update']);
        Route::post('', [OrderController::class, 'store']);
        Route::get('discount/{orderId}', [DiscountController::class, 'discount']);
     });
 });
