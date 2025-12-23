<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NpcController;
use App\Http\Controllers\ServerInfoController;
use App\Http\Controllers\ItemController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('server-info', [ServerInfoController::class, 'index']);
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
    Route::prefix('npcs')->group(function () {
        Route::get('/', [NpcController::class, 'index']);
        Route::get('/biomes', [NpcController::class, 'biomes']);
        Route::get('/professions', [NpcController::class, 'professions']);
        Route::post('/', [NpcController::class, 'bulkSave']);
    });
    Route::prefix('items')->group(function () {
        Route::get('/', [ItemController::class, 'index']);
        Route::patch('/', [ItemController::class, 'update']);
    });
});
