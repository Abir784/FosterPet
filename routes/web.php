<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProfileController;

// Home page
Route::get('/', function () {
    return view('index');
});

// Admin custom form (optional)
Route::get('/saud', function () {
    return view('admin_dashboard_form');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes that require login
Route::middleware('auth')->group(function () {
    // PET STATUS DASHBOARD
    Route::get('/dashboard/pets', [PetController::class, 'dashboard'])->name('pets.dashboard');
    Route::post('/dashboard/pets/{id}/status', [PetController::class, 'updateStatus'])->name('pets.updateStatus');

    // User Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Auth scaffolding
require __DIR__.'/auth.php';
