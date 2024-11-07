<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/inventory', [InventoryController::class, 'index']);

Route::resource('inventory', InventoryController::class);

Route::middleware(['auth'])->group(function () {
    Route::resource('inventory', InventoryController::class);
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
