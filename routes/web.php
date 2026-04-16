<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiceItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rice Menu Management (CRUD)
    Route::resource('rice-items', RiceItemController::class);

    // Order Management
    Route::resource('orders', OrderController::class);

    // Payment Management
    Route::post('/orders/{order}/pay', [PaymentController::class, 'process'])->name('payments.process');
    Route::get('/payments/history', [PaymentController::class, 'history'])->name('payments.history');
});

require __DIR__.'/auth.php';