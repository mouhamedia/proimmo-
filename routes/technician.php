<?php

use App\Http\Controllers\Technician\DashboardController;
use App\Http\Controllers\Technician\TicketController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:maintenance'])
    ->prefix('technician')
    ->name('technician.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::patch('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
    });
