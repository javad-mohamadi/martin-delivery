<?php

use App\Http\Controllers\General\V1\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', array(AuthController::class, 'loginUsingPasswordGrant'))->name('login');
