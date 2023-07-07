<?php

use App\Http\Controllers\Api\V1\CompanyOrderController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'company-orders'], function () {
    Route::get('/', [CompanyOrderController::class, 'index']);
    Route::get('/{id}', [CompanyOrderController::class, 'show']);
    Route::post('/', [CompanyOrderController::class, 'create']);
    Route::patch('/{id}', [CompanyOrderController::class, 'update']);
});
