<?php

declare(strict_types=1);

use App\Http\Controllers\LicenseKeys\LicenseKeyController;
use App\Http\Controllers\LicenseKeys\LicenseKeyExportController;
use App\Http\Controllers\LicenseKeys\LicenseKeyExtendController;
use App\Http\Controllers\LicenseKeys\LicenseKeyRestoreController;
use App\Http\Controllers\LicenseKeys\LicenseKeyRevokeController;
use App\Http\Controllers\LicenseKeys\LicenseKeyTypeController;
use App\Http\Controllers\LicenseKeys\LicenseKeyTypePreviewController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/', [LicenseKeyController::class, 'index'])->name('index');
    Route::post('/', [LicenseKeyController::class, 'store'])->name('store');

    Route::get('/bulk', [LicenseKeyController::class, 'bulkCreate'])->name('bulk.create');
    Route::post('/bulk', [LicenseKeyController::class, 'bulkStore'])->name('bulk.store');

    Route::get('/export', [LicenseKeyExportController::class, 'export'])->name('export');

    Route::get('/types', [LicenseKeyTypeController::class, 'index'])->name('types.index');
    Route::post('/types', [LicenseKeyTypeController::class, 'store'])->name('types.store');
    Route::post('/types/preview', [LicenseKeyTypePreviewController::class, 'preview'])->name('types.preview');
    Route::patch('/types/{licenseKeyType:uuid}', [LicenseKeyTypeController::class, 'update'])->name('types.update');
    Route::delete('/types/{licenseKeyType:uuid}', [LicenseKeyTypeController::class, 'destroy'])->name('types.destroy');

    Route::get('/{licenseKey:uuid}', [LicenseKeyController::class, 'show'])->name('show');
    Route::get('/{licenseKey:uuid}/edit', [LicenseKeyController::class, 'edit'])->name('edit');
    Route::patch('/{licenseKey:uuid}', [LicenseKeyController::class, 'update'])->name('update');

    Route::post('/{licenseKey:uuid}/revoke', [LicenseKeyRevokeController::class, 'revoke'])->name('revoke');
    Route::post('/{licenseKey:uuid}/restore', [LicenseKeyRestoreController::class, 'restore'])->name('restore');
    Route::post('/{licenseKey:uuid}/extend', [LicenseKeyExtendController::class, 'extend'])->name('extend');
});
