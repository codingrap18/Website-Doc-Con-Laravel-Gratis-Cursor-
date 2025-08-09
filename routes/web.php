<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TransmittalController;
use App\Http\Controllers\NotificationController;

// Redirect root to login or dashboard
Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/notifications/unread-count', [DashboardController::class, 'getUnreadNotificationCount']);

    // Documents
    Route::resource('documents', DocumentController::class);
    Route::post('/documents/bulk-update', [DocumentController::class, 'bulkUpdate'])->name('documents.bulk-update');
    Route::get('/documents/export/excel', [DocumentController::class, 'exportExcel'])->name('documents.export.excel');
    Route::get('/documents/export/pdf', [DocumentController::class, 'exportPdf'])->name('documents.export.pdf');

    // Reviews
    Route::resource('reviews', ReviewController::class)->except(['edit', 'destroy']);
    Route::get('/reviews/pending', [ReviewController::class, 'pending'])->name('reviews.pending');
    Route::get('/documents/{document}/review', [ReviewController::class, 'create'])->name('documents.review');
    Route::post('/documents/{document}/review', [ReviewController::class, 'store'])->name('documents.review.store');

    // Transmittal Letters
    Route::resource('transmittals', TransmittalController::class);
    Route::get('/transmittals/{transmittal}/pdf', [TransmittalController::class, 'generatePdf'])->name('transmittals.pdf');
    Route::get('/transmittals/{transmittal}/download', [TransmittalController::class, 'downloadPdf'])->name('transmittals.download');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/api/notifications/unread-count', [NotificationController::class, 'getUnreadCount']);
    Route::patch('/api/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::patch('/api/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
    Route::delete('/api/notifications/{id}', [NotificationController::class, 'destroy']);
});
