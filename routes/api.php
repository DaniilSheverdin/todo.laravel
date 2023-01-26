<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ItemController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/items', [ItemController::class, 'index']);

Route::prefix('/item')->group(function () {
    Route::post('/store', [ItemController::class, 'store']);
    Route::get('/{id}', [ItemController::class, 'show']);
    Route::patch('/{id}', [ItemController::class, 'update']);
    Route::put('/{id}', [ItemController::class, 'edit']);
    Route::delete('/{id}', [ItemController::class, 'destroy']);
});

