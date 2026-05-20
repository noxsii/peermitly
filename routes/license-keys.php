<?php

declare(strict_types=1);

use App\Http\Controllers\LicenseKeys\LicenseKeyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/', [LicenseKeyController::class, 'index'])->name('index');
});
