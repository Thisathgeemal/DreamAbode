<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectAdController;
use App\Http\Controllers\PropertyAdController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('admins', AdminController::class);
    Route::apiResource('agents', AgentController::class);
    Route::apiResource('members', UserController::class);
    Route::apiResource('propertyAd', PropertyAdController::class);
    Route::apiResource('projectAd', ProjectAdController::class);
    Route::apiResource('subscriptionType', SubscriptionTypeController::class);
    Route::apiResource('subscription', SubscriptionController::class);
    Route::apiResource('payments', PaymentController::class);
    Route::apiResource('reports', ReportController::class);
    Route::apiResource('reviews', ReviewController::class);
    Route::apiResource('notification', NotificationController::class);

    Route::post('/propertyAd/payment', [PropertyAdController::class, 'payment'])->name('property.payment');
    Route::put('/propertyAd/accept/{property}', [PropertyAdController::class, 'accept'])->name('property.accept');
    Route::put('/propertyAd/reject/{property}', [PropertyAdController::class, 'reject'])->name('property.reject');

    Route::post('/projectAd/payment', [ProjectAdController::class, 'payment'])->name('project.payment');
    Route::put('/projectAd/accept/{project}', [ProjectAdController::class, 'accept'])->name('project.accept');
    Route::put('/projectAd/reject/{project}', [ProjectAdController::class, 'reject'])->name('project.reject');

    Route::put('reviews/{review}/hide', [ReviewController::class, 'hideReview']);
    Route::put('reviews/{review}/show', [ReviewController::class, 'showReview']);
});
