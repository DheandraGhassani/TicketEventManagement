<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| HOME (ROLE BASED)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (Auth::check()) {
        if (Auth::user()->role_id == 1) {
            return redirect('/admin');
        }
    }

    $events = \App\Models\Event::all();
    return view('home', compact('events'));
});

/*
|--------------------------------------------------------------------------
| EVENT (USER)
|--------------------------------------------------------------------------
*/

// detail event → pilih tiket
Route::get('/event/{id}', function ($id) {
    $event = \App\Models\Event::with('tickets')->findOrFail($id);
    return view('event_detail', compact('event'));
});

/*
|--------------------------------------------------------------------------
| ADMIN LOGIN (DEV ONLY 🔥)
|--------------------------------------------------------------------------
*/

Route::get('/login-admin', function () {
    $admin = User::where('role_id', 1)->first();
    Auth::login($admin);
    return redirect('/');
});

/*
|--------------------------------------------------------------------------
| ADMIN (SEMUA DALAM GROUP 🔥)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:1'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | GLOBAL DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/event/create', [AdminController::class, 'createEvent']);
    Route::post('/admin/event/store', [AdminController::class, 'storeEvent']);

    /*
    |--------------------------------------------------------------------------
    | PER EVENT DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/event/{id}', [AdminController::class, 'eventDashboard']);

    /*
    |--------------------------------------------------------------------------
    | TICKET CRUD (PER EVENT SAJA ✅)
    |--------------------------------------------------------------------------
    */
    Route::post('/admin/event/{id}/tickets', [AdminController::class, 'storeTicketByEvent']);
    Route::post('/admin/tickets/{id}/update', [AdminController::class, 'updateTicket']);
    Route::post('/admin/tickets/{id}/delete', [AdminController::class, 'deleteTicket']);

    /*
    |--------------------------------------------------------------------------
    | WAITING LIST & ORDER
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/waiting-list', [AdminController::class, 'waitingList']);
    Route::get('/admin/orders/{id}', [AdminController::class, 'orderDetail']);
});

/*
|--------------------------------------------------------------------------
| BUY TICKET (USER)
|--------------------------------------------------------------------------
*/

// halaman beli tiket (opsional kalau masih dipakai)
Route::get('/buy', function () {
    $tickets = \App\Models\Ticket::all();
    return view('buy', compact('tickets'));
});

// submit beli tiket → create order (pending)
Route::post('/buy', [TicketController::class, 'buy']);

/*
|--------------------------------------------------------------------------
| PAYMENT
|--------------------------------------------------------------------------
*/

// halaman pembayaran
Route::get('/payment/{id}', [PaymentController::class, 'show']);

// simulasi bayar
Route::post('/payment/{id}/pay', [PaymentController::class, 'pay']);
Route::post('/payment/{id}/fail', [PaymentController::class, 'fail']);

// sukses
Route::get('/success/{id}', function ($id) {
    $order = \App\Models\Order::findOrFail($id);
    return view('success', compact('order'));
});

/*
|--------------------------------------------------------------------------
| QR SCAN
|--------------------------------------------------------------------------
*/

Route::get('/scan/{code}', [ScanController::class, 'scan']);

// halaman scanner UI
Route::get('/scanner', function () {
    return view('scanner');
});

/*
|--------------------------------------------------------------------------
| AUTH (DEFAULT LARAVEL)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';    