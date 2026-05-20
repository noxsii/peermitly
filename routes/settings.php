<?php

declare(strict_types=1);

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\SettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/', [SettingsController::class, 'edit'])->name('edit');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
});
