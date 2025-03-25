<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

Route::redirect('/','tick')->name('dashboard');

Route::middleware(['auth','verified'])->group(function(){
    Route::resource('tick', TicketController::class);
    Route::get('/tick/machines/search', [TicketController::class, 'searchMachines'])->name('machines.search');
});

Route::middleware(['auth', 'verified', AdminMiddleware::class])->group(function () {
    Route::get('/accounts', [RegisteredUserController::class, 'index'])->name('accounts.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
