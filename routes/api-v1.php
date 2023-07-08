<?php

use App\Http\Controllers\Api\V1\CompanyOrderController;
use App\Http\Controllers\Api\V1\CourierOrderController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'company'], function () {
    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', [CompanyOrderController::class, 'index']);
        Route::get('/{id}', [CompanyOrderController::class, 'show']);
        Route::post('/', [CompanyOrderController::class, 'create']);
        Route::patch('/{id}', [CompanyOrderController::class, 'update']);
    });
});

Route::prefix('courier')->group(function () {
    Route::prefix('orders')->group(function () {
        Route::get('/pending', [CourierOrderController::class, 'getPendingOrders']);
        Route::get('', [CourierOrderController::class, 'index']);
        Route::get('/{id}', [CourierOrderController::class, 'show']);
        Route::post('', [CourierOrderController::class, 'acceptOrder']);
        Route::patch('/{id}', [CourierOrderController::class, 'update']);
    });
});
