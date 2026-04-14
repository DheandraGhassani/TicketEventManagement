<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ETicketController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketTypeController;
use App\Http\Controllers\WaitingListController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ─── Events (bisa diakses semua user, tapi create/edit/delete hanya admin/organizer) ───
    // Definisikan /events/create SEBELUM /events/{event} agar tidak bentrok routing
    Route::middleware(['role:admin,organizer'])->group(function () {
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

        // Ticket Types (shallow resource — edit/update/destroy tanpa prefix event)
        Route::get('/events/{event}/ticket-types', [TicketTypeController::class, 'index'])->name('ticket-types.index');
        Route::post('/events/{event}/ticket-types', [TicketTypeController::class, 'store'])->name('ticket-types.store');
        Route::get('/ticket-types/{ticketType}/edit', [TicketTypeController::class, 'edit'])->name('ticket-types.edit');
        Route::put('/ticket-types/{ticketType}', [TicketTypeController::class, 'update'])->name('ticket-types.update');
        Route::delete('/ticket-types/{ticketType}', [TicketTypeController::class, 'destroy'])->name('ticket-types.destroy');

        // Categories
        Route::resource('categories', CategoryController::class);

        // Scan Tiket
        Route::get('/tickets/scan', [ETicketController::class, 'index'])->name('tickets.scan.index');
        Route::post('/tickets/scan', [ETicketController::class, 'scan'])->name('tickets.scan');

        // Export Excel
        Route::get('/dashboard/export', [DashboardController::class, 'exportExcel'])->name('dashboard.export');
    });

    // Events index & show — semua user terautentikasi bisa akses
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

    // ─── Orders & Payment ───
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/success/{id}', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/payments/{order}/simulate', [PaymentController::class, 'simulate'])->name('payments.simulate');
    Route::post('/payments/{order}/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');

    // ─── Waiting List ───
    Route::get('/waiting-list', [WaitingListController::class, 'index'])->name('waiting-list.index');
    Route::post('/waiting-list/{event}', [WaitingListController::class, 'join'])->name('waiting-list.join');
    Route::delete('/waiting-list/{event}', [WaitingListController::class, 'leave'])->name('waiting-list.leave');

    // ─── Profile ───
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
