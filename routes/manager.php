<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manager\LeaseController;
use App\Http\Controllers\Manager\PaymentController;
use App\Http\Controllers\Manager\ApartmentController;
use App\Http\Controllers\Manager\BuildingController;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\MaintenanceWorkerController;
use App\Http\Controllers\Manager\ReportController;
use App\Http\Controllers\Manager\TenantController;
use App\Http\Controllers\SettingsController;

Route::middleware(['auth'])->prefix('manager')->name('manager.')->group(function () {
	Route::resource('buildings', BuildingController::class);
	Route::resource('apartments', ApartmentController::class);
	Route::resource('tenants', TenantController::class);
	Route::resource('maintenance_workers', MaintenanceWorkerController::class);
	Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->prefix('manager')->group(function () {
	Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
	Route::get('leases', [LeaseController::class, 'index'])->name('leases.index');
	Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
	Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
});
