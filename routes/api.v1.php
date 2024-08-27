<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\{Auth\AuthController,User\UserController};

/*
|--------------------------------------------------------------------------
| Auth routes
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('registration', 'registration');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [AuthController::class , 'profile']);
    Route::apiResource('user', UserController::class);
});
