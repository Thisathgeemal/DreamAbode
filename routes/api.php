<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\PropertyAdController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('admins', AdminController::class);
    Route::apiResource('agents', AgentController::class);
    Route::apiResource('members', UserController::class);
    Route::apiResource('propertyAd', PropertyAdController::class);
    Route::apiResource('reports', ReportController::class);

    Route::post('/propertyAd/payment', [PropertyAdController::class, 'payment'])->name('property.payment');
    Route::put('/propertyAd/accept/{property}', [PropertyAdController::class, 'accept'])->name('property.accept');
    Route::put('/propertyAd/reject/{property}', [PropertyAdController::class, 'reject'])->name('property.reject');
});
