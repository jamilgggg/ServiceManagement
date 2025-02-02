<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

//Route::get('/tick', [TicketController::class, 'index'])->name('tick.index');
Route::resource('tick', TicketController::class);
Route::get('/tick/machines/search', [TicketController::class, 'searchMachines'])->name('machines.search');
