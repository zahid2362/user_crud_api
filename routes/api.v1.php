<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\{Auth\AuthController,User\UserController};
use Illuminate\Http\Request;

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
    Route::get('me', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('user', UserController::class);
});
