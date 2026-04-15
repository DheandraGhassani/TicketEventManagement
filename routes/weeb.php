<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\StudentController;
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

// Route::get('/about', function () {
//     return "halaman about";
// });

// Route::get('/student', [StudentController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', function () {
        return view('starter');
    })->name('home');

    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');

    Route::middleware('role:1')->group(function() {    
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/category/create', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('/category/{category}/edit', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/{category}/delete', [CategoryController::class, 'destroy'])->name('category.delete');
    });

});

require __DIR__.'/auth.php';
