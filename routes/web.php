<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

Route::get('/', static fn (): View => view('app'));

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
});
