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

    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/admin', fn() => view('admin.usersAdmin'))->name('admin');
        Route::get('/agents', fn() => view('admin.usersAgents'))->name('agents');
        Route::get('/members', fn() => view('admin.usersMembers'))->name('members');
    });

    Route::prefix('admin/property')->name('admin.property.')->group(function () {
        Route::get('/pending', fn() => view('admin.propertyPending'))->name('pending');
        Route::get('/accepted', fn() => view('admin.propertyAccepted'))->name('accepted');
        Route::get('/rejected', fn() => view('admin.propertyRejected'))->name('rejected');
        Route::get('/completed', fn() => view('admin.propertyCompleted'))->name('completed');
        Route::get('/viewAd/{id}', fn($id) => view('admin.viewProperty', ['propertyId' => $id]))->name('viewAd');
    });

    Route::prefix('admin/project')->name('admin.project.')->group(function () {
        Route::get('/pending', fn() => view('admin.projectPending'))->name('pending');
        Route::get('/accepted', fn() => view('admin.projectAccepted'))->name('accepted');
        Route::get('/rejected', fn() => view('admin.projectRejected'))->name('rejected');
        Route::get('/completed', fn() => view('admin.projectCompleted'))->name('completed');
        Route::get('/viewAd/{id}', fn($id) => view('admin.viewProject', ['projectId' => $id]))->name('viewAd');
    });

    Route::prefix('admin/membership')->name('admin.membership.')->group(function () {
        Route::get('/type', fn() => view('admin.membershipType'))->name('type');
        Route::get('/subscriptions', fn() => view('admin.membership'))->name('subscriptions');
    });

    Route::get('/admin/messages/{userId?}', function ($userId = null) {
        return view('admin.messages', ['userId' => $userId]);
    })->name('admin.messages');

    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/admin/payment', fn() => view('admin.payment'))->name('admin.payment');
    Route::get('/admin/feedback', fn() => view('admin.feedback'))->name('admin.feedback');
    Route::get('/admin/profile', fn() => view('admin.profile'))->name('admin.profile');
    Route::get('/admin/notification', fn() => view('admin.notification'))->name('admin.notification');

});

// Authenticated Agent Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::prefix('agent/property')->name('agent.property.')->group(function () {
        Route::get('/assigned', fn() => view('agent.propertyAssigned'))->name('assigned');
        Route::get('/completed', fn() => view('agent.propertyCompleted'))->name('completed');
        Route::get('/viewAd/{id}', fn($id) => view('agent.viewProperty', ['propertyId' => $id]))->name('viewAd');
    });

    Route::prefix('agent/project')->name('agent.project.')->group(function () {
        Route::get('/assigned', fn() => view('agent.projectAssigned'))->name('assigned');
        Route::get('/completed', fn() => view('agent.projectCompleted'))->name('completed');
        Route::get('/viewAd/{id}', fn($id) => view('agent.viewProject', ['projectId' => $id]))->name('viewAd');
    });

    Route::get('/agent/messages/{userId?}', function ($userId = null) {
        return view('agent.messages', ['userId' => $userId]);
    })->name('agent.messages');

    Route::get('/agent/dashboard', fn() => view('agent.dashboard'))->name('agent.dashboard');
    Route::get('/agent/profile', fn() => view('agent.profile'))->name('agent.profile');
    Route::get('/agent/notification', fn() => view('agent.notification'))->name('agent.notification');

});

// Authenticated Member Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::prefix('member/property')->name('member.property.')->group(function () {
        Route::get('/pending', fn() => view('member.propertyPending'))->name('pending');
        Route::get('/accepted', fn() => view('member.propertyAccepted'))->name('accepted');
        Route::get('/rejected', fn() => view('member.propertyRejected'))->name('rejected');
        Route::get('/completed', fn() => view('member.propertyCompleted'))->name('completed');
        Route::get('/postAd', fn() => view('member.postProperty'))->name('postAd');
        Route::get('/editAd/{id}', fn($id) => view('member.editProperty', ['propertyId' => $id]))->name('editAd');
        Route::get('/viewAd/{id}', fn($id) => view('member.viewProperty', ['propertyId' => $id]))->name('viewAd');
    });

    Route::prefix('member/project')->name('member.project.')->group(function () {
        Route::get('/pending', fn() => view('member.projectPending'))->name('pending');
        Route::get('/accepted', fn() => view('member.projectAccepted'))->name('accepted');
        Route::get('/rejected', fn() => view('member.projectRejected'))->name('rejected');
        Route::get('/completed', fn() => view('member.projectCompleted'))->name('completed');
        Route::get('/postAd', fn() => view('member.postProject'))->name('postAd');
        Route::get('/editAd/{id}', fn($id) => view('member.editProject', ['projectId' => $id]))->name('editAd');
        Route::get('/viewAd/{id}', fn($id) => view('member.viewProject', ['projectId' => $id]))->name('viewAd');
    });

    Route::get('/member/messages/{userId?}', function ($userId = null) {
        return view('member.messages', ['userId' => $userId]);
    })->name('member.messages');

    Route::get('/member/dashboard', fn() => view('member.dashboard'))->name('member.dashboard');
    Route::get('/member/membership', fn() => view('member.membership'))->name('member.membership');
    Route::get('/member/payment', fn() => view('member.payment'))->name('member.payment');
    Route::get('/member/feedback', fn() => view('member.feedback'))->name('member.feedback');
    Route::get('/member/profile', fn() => view('member.profile'))->name('member.profile');
    Route::get('/member/notification', fn() => view('member.notification'))->name('member.notification');
});
