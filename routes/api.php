<?php

use App\Http\Controllers\Api\AuthenticatedUserController;
use App\Http\Controllers\Api\ChannelController;
use App\Http\Controllers\Api\ChannelMessageController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;

Route::post('login', [AuthenticatedUserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());

    Route::get('messages/{receiver}', [MessageController::class, 'index']);
    Route::post('messages', [MessageController::class, 'store']);
    Route::post('messages/{sender_id}/messages_read', [MessageController::class, 'messageRead']);
    Route::get('users', [UserController::class, 'index']);
    Route::get('channels', [ChannelController::class, 'index']);
    Route::apiResource('channels/{id}/messages', ChannelMessageController::class)->only(['index', 'store']);
});
