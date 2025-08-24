<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CutiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// routes/web.php
Route::prefix('hr')->group(function () {
    Route::get('/cuti/management', [CutiController::class, 'indexAll'])->name('hr.management');
    Route::post('/cuti/{id}/approve', [CutiController::class, 'approve'])->name('hr.cuti.approve');
    Route::post('/cuti/{id}/reject', [CutiController::class, 'reject'])->name('hr.cuti.reject');
});


Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD cuti untuk semua user
 Route::resource('cuti', CutiController::class)->except(['show']);


    
});

require __DIR__.'/auth.php';
