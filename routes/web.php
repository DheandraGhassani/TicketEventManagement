<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketTypeController;
use App\Http\Controllers\ETicketController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Grouping Admin & Organizer
    Route::middleware(['role:admin,organizer'])->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('events', EventController::class);
        Route::resource('events.ticket-types', TicketTypeController::class)->shallow();
        
        // Route untuk Scan Tiket
        Route::post('/tickets/scan', [ETicketController::class, 'scan'])->name('tickets.scan');
    });

    // Grouping User (Pembeli)
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/success/{id}', [OrderController::class, 'success'])->name('orders.success');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';