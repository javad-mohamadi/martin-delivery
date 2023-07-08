<?php

use App\Http\Controllers\General\V1\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'loginUsingPasswordGrant'])->name('login');
