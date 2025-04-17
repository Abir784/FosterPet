<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PetsController;


// Home page
Route::get('/', function () {
    return view('index');
});

//Route::get('/pets', function () {
   // return view('admin_dashboard_form');
  // return view('pets.show_pets');
//});

Route::middleware('auth')->group(function () {
    Route::get('/pets/add',[PetsController::class,'add_pets'])->name('pets.add_pets');
    Route::post('/pets/update', [PetsController::class, 'update_pets'])->name('pets.update_pet');
    Route::delete('/pets/delete', [PetsController::class, 'destroy_pet'])->name('pets.destroy_pet');
    Route::get("/pets/details",[PetsController::class,"show_pets"])->name('show.pets');

});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes that require login
Route::middleware('auth')->group(function () {
    // PET STATUS DASHBOARD
  

    // User Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// Auth scaffolding
require __DIR__.'/auth.php';
