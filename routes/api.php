<?php

use App\Http\Controllers\Api\ClockRecordController;
use App\Http\Controllers\Api\PasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->post('/change-password', [PasswordController::class, 'update']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/clock-in', [ClockRecordController::class, 'register']);
    Route::get('/report', [ClockRecordController::class, 'report']);
});

Route::middleware('auth:sanctum')->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('{id}', [UserController::class, 'show']);
    Route::put('{id}', [UserController::class, 'update']);
    Route::delete('{id}', [UserController::class, 'destroy']);
});
