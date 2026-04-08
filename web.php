<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ScanController;

Route::get('/buy', function () {
    $tickets = \App\Models\Ticket::all();
    return view('buy', compact('tickets'));
});
Route::post('/buy', [TicketController::class, 'buy']);
Route::get('/scan/{code}', [ScanController::class, 'scan']);
Route::get('/scanner', function () {
    return view('scanner');
});


require __DIR__.'/auth.php';