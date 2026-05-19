<?php

declare(strict_types=1);

use App\Http\Controllers\LoginController;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

Route::get('/', static fn (): View => view('app'));

Route::get('/login', [LoginController::class, 'index'])->name('login');