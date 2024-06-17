<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('Sistema')->group(function () {

        // Panel principal
        Route::get('Dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Departamentos
        Route::controller(DepartamentoController::class)->group(function () {
            Route::get('Departamentos', 'index')->name('departamentos');
            Route::get('Departamentos/Lista', 'lista')->name('departamentos.lista');
            Route::post('Departamentos', 'crear')->name('departamentos.crear');
            Route::get('Departamentos/dato/{id?}', 'consulta')->name('departamentos.consulta');
            Route::post('Departamentos/Editar/{id?}', 'editar')->name('departamentos.editar');
            Route::delete('Departamentos/{id?}', 'eliminar')->name('departamentos.eliminar');
        });

        // Empleados
        Route::controller(EmpleadoController::class)->group(function () {
            Route::get('Empleados', 'index')->name('empleados');
            Route::get('Empleados/Lista', 'lista')->name('empleados.lista');
        });

    });
});