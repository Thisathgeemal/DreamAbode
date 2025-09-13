<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/sales', function () {
    return view('sales');
})->name('sales');

Route::get('/rentals', function () {
    return view('rentals');
})->name('rentals');

Route::get('/projects', function () {
    return view('projects');
})->name('projects');

Route::get('/loans', function () {
    return view('loans');
})->name('loans');

Route::get('/about', function () {
    return view('about');
})->name('about');

// Routes for Google login (guests)
Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Routes for Facebook login (guests)
Route::get('login/facebook', [FacebookController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

// Routes for authenticated users
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/select-role', [AuthController::class, 'select'])->name('role.selection');
    Route::post('/select-role', [AuthController::class, 'store'])->name('role.selection.store');
});

// Authenticated Admin Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

    // Manage Users
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/admin', fn() => view('admin.usersAdmin'))->name('admin');
        Route::get('/agents', fn() => view('admin.usersAgents'))->name('agents');
        Route::get('/members', fn() => view('admin.usersMembers'))->name('members');
    });

    // Manage Property
    Route::prefix('admin/property')->name('admin.property.')->group(function () {
        Route::get('/pending', fn() => view('admin.propertyPending'))->name('pending');
        Route::get('/accepted', fn() => view('admin.propertyAccepted'))->name('accepted');
        Route::get('/rejected', fn() => view('admin.propertyRejected'))->name('rejected');
        Route::get('/completed', fn() => view('admin.propertyCompleted'))->name('completed');
        Route::get('/viewAd/{id}', fn($id) => view('admin.viewProperty', ['propertyId' => $id]))->name('viewAd');
    });

    // Manage Project
    Route::prefix('admin/project')->name('admin.project.')->group(function () {
        Route::get('/pending', fn() => view('admin.projectPending'))->name('pending');
        Route::get('/accepted', fn() => view('admin.projectAccepted'))->name('accepted');
        Route::get('/rejected', fn() => view('admin.projectRejected'))->name('rejected');
        Route::get('/completed', fn() => view('admin.projectCompleted'))->name('completed');
    });

    // Manage Membership
    Route::prefix('admin/membership')->name('admin.membership.')->group(function () {
        Route::get('/type', fn() => view('admin.membershipType'))->name('type');
        Route::get('/subscriptions', fn() => view('admin.membership'))->name('subscriptions');
    });

    // Payment
    Route::get('/admin/payment', fn() => view('admin.payment'))->name('admin.payment');

    // Messages
    Route::get('/admin/messages', fn() => view('admin.messages'))->name('admin.messages');

    // Feedback
    Route::get('/admin/feedback', fn() => view('admin.feedback'))->name('admin.feedback');

});

// Authenticated Agent Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard
    Route::get('/agent/dashboard', fn() => view('agent.dashboard'))->name('agent.dashboard');

    // Property
    Route::get('/agent/property', fn() => view('agent.property'))->name('agent.property');

    // Project
    Route::get('/agent/project', fn() => view('agent.project'))->name('agent.project');

    // Messages
    Route::get('/agent/messages', fn() => view('agent.messages'))->name('agent.messages');

});

// Authenticated Member Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard
    Route::get('/member/dashboard', fn() => view('member.dashboard'))->name('member.dashboard');

    // Manage Property Routes
    Route::prefix('member/property')->name('member.property.')->group(function () {
        Route::get('/pending', fn() => view('member.propertyPending'))->name('pending');
        Route::get('/accepted', fn() => view('member.propertyAccepted'))->name('accepted');
        Route::get('/rejected', fn() => view('member.propertyRejected'))->name('rejected');
        Route::get('/completed', fn() => view('member.propertyCompleted'))->name('completed');
        Route::get('/postAd', fn() => view('member.postProperty'))->name('postAd');
        Route::get('/editAd/{id}', fn($id) => view('member.editProperty', ['propertyId' => $id]))->name('editAd');
        Route::get('/viewAd/{id}', fn($id) => view('member.viewProperty', ['propertyId' => $id]))->name('viewAd');
    });

    // Manage Project Routes
    Route::prefix('member/project')->name('member.project.')->group(function () {
        Route::get('/pending', fn() => view('member.projectPending'))->name('pending');
        Route::get('/accepted', fn() => view('member.projectAccepted'))->name('accepted');
        Route::get('/rejected', fn() => view('member.projectRejected'))->name('rejected');
        Route::get('/completed', fn() => view('member.projectCompleted'))->name('completed');
        Route::get('/postAd', fn() => view('member.postProject'))->name('postAd');
    });

    // Membership
    Route::get('/member/membership', fn() => view('member.membership'))->name('member.membership');

    // Payment
    Route::get('/member/payment', fn() => view('member.payment'))->name('member.payment');

    // Messages
    Route::get('/member/messages', fn() => view('member.messages'))->name('member.messages');

    // Feedback / Review
    Route::get('/member/feedback', fn() => view('member.feedback'))->name('member.feedback');

});
