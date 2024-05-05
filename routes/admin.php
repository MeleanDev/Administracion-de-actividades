<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('Sistema')->group(function () {

        Route::get('Dashboard', [DashboardController::class, 'index'])->name('dashboard');

    });
});