<?php

use App\Http\Controllers\AdoptionController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PetsController;


// Home page
Route::get('/', function () {
    return view('index');
});



// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes that require login
Route::middleware('auth')->group(function () {



    // User Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/pets/add',[PetsController::class,'add_pets'])->name('pets.add_pets');
    Route::post('/pets/update', [PetsController::class, 'update_pets'])->name('pets.update_pet');
    Route::delete('/pets/delete', [PetsController::class, 'destroy_pet'])->name('pets.destroy_pet');
    Route::get("/pets/details",[PetsController::class,"show_pets"])->name('show.pets');
    Route::get("/pets/adopt/show",[AdoptionController::class,"adpotion_list"])->name('track.requests');

});

// Auth scaffolding
require __DIR__.'/auth.php';
