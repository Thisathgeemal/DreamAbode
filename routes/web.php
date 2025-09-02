<?php

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

// Authenticated Member Dashboard Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard
    Route::get('/memberDashboard', function () {
        return view('memberDashboard.memberDashboard');
    })->name('memberDashboard');

    // Manage Property Routes
    Route::prefix('property')->group(function () {
        Route::get('/pending', function () {
            return view('property.pending');
        })->name('property.pending');

        Route::get('/accepted', function () {
            return view('property.accepted');
        })->name('property.accepted');

        Route::get('/rejected', function () {
            return view('property.rejected');
        })->name('property.rejected');
    });

    // Manage Project Routes
    Route::prefix('project')->group(function () {
        Route::get('/pending', function () {
            return view('project.pending');
        })->name('project.pending');

        Route::get('/accepted', function () {
            return view('project.accepted');
        })->name('project.accepted');

        Route::get('/rejected', function () {
            return view('project.rejected');
        })->name('project.rejected');
    });

    // Membership
    Route::get('/membership', function () {
        return view('membership');
    })->name('membership');

    // Payment
    Route::get('/payment', function () {
        return view('payment');
    })->name('payment');

    // Messages
    Route::get('/messages', function () {
        return view('messages');
    })->name('messages');

    // Review
    Route::get('/review', function () {
        return view('review');
    })->name('review');
});
