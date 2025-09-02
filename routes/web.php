<?php

use App\Http\Controllers\AuthController;
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

Route::middleware(['auth:sanctum',
    config('jetstream.auth_session'),
    'verified'])->group(function () {
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
    Route::prefix('admin/users')->group(function () {
        Route::get('/admin', fn() => view('admin.usersAdmin'))->name('users.admin');
        Route::get('/agents', fn() => view('admin.usersAgents'))->name('users.agents');
        Route::get('/members', fn() => view('admin.usersMembers'))->name('users.members');
    });

    // Manage Property
    Route::prefix('admin/property')->group(function () {
        Route::get('/pending', fn() => view('admin.propertyPending'))->name('property.pending');
        Route::get('/accepted', fn() => view('admin.propertyAccepted'))->name('property.accepted');
        Route::get('/rejected', fn() => view('admin.propertyRejected'))->name('property.rejected');
    });

    // Manage Project
    Route::prefix('admin/project')->group(function () {
        Route::get('/pending', fn() => view('admin.projectPending'))->name('project.pending');
        Route::get('/accepted', fn() => view('admin.projectAccepted'))->name('project.accepted');
        Route::get('/rejected', fn() => view('admin.projectRejected'))->name('project.rejected');
    });

    // Membership
    Route::get('/admin/membership', fn() => view('admin.membership'))->name('membership');

    // Payment
    Route::get('/admin/payment', fn() => view('admin.payment'))->name('payment');

    // Messages
    Route::get('/admin/messages', fn() => view('admin.messages'))->name('messages');

    // Feedback
    Route::get('/admin/feedback', fn() => view('admin.feedback'))->name('feedback');

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
    Route::get('/agent/property', fn() => view('agent.property'))->name('property');

    // Project
    Route::get('/agent/project', fn() => view('agent.project'))->name('project');

    // Messages
    Route::get('/agent/messages', fn() => view('agent.messages'))->name('messages');

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
    });

    // Manage Project Routes
    Route::prefix('member/project')->name('member.project.')->group(function () {
        Route::get('/pending', fn() => view('member.projectPending'))->name('pending');
        Route::get('/accepted', fn() => view('member.projectAccepted'))->name('accepted');
        Route::get('/rejected', fn() => view('member.projectRejected'))->name('rejected');
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
