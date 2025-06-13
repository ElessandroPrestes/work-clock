<?php

use App\Http\Controllers\Api\ClockRecordController;
use App\Http\Controllers\Api\PasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FuncionarioController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->post('/trocar-senha', [PasswordController::class, 'update']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/ponto', [ClockRecordController::class, 'registrar']);
    Route::get('/relatorio', [ClockRecordController::class, 'relatorio']);
});

Route::middleware('auth:sanctum')->prefix('funcionarios')->group(function () {
    Route::get('/', [FuncionarioController::class, 'index']);
    Route::post('/', [FuncionarioController::class, 'store']);
    Route::get('{id}', [FuncionarioController::class, 'show']);
    Route::put('{id}', [FuncionarioController::class, 'update']);
    Route::delete('{id}', [FuncionarioController::class, 'destroy']);
});

