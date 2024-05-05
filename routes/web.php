<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('Sistema/Perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('Sistema/Perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('Sistema/Perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
