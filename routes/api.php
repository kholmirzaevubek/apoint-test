<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SmsController;
use Illuminate\Support\Facades\Route;

Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::post('/', [ProjectController::class, 'store']);
    Route::patch('/{project}', [ProjectController::class, 'update']);
});

Route::post('/sms/send', [SmsController::class, 'send']);
Route::get('/sms/history', [SmsController::class, 'history']);
