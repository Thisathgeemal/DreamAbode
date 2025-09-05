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
});
