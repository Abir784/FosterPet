<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PetsController;


Route::get('/', function () {
    return view('index');
});




// Dashboard

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pets
    Route::get('/pets/add', [PetsController::class, 'add_pets'])->name('pets.add_pets');
    Route::post('/pets/update', [PetsController::class, 'update_pets'])->name('pets.update_pet');
    Route::delete('/pets/delete', [PetsController::class, 'destroy_pet'])->name('pets.destroy_pet');
    Route::get('/pets/details', [PetsController::class, 'show_pets'])->name('show.pets');

    // Adoption
    Route::get('/pets/adopt/show', [AdoptionController::class, 'adpotion_list'])->name('track.requests');
    Route::get('/adoption/status', [AdoptionController::class, 'updateStatus'])->name('adoption.status');
    Route::post('/adoption/update/{id}', [AdoptionController::class, 'updateStatus'])->name('adoption.update');

    // Add this route to fix the "adoption.index not defined" error
    Route::get('/adoption', [AdoptionController::class, 'show_adoption'])->name('adoption.index');
});

require __DIR__.'/auth.php';
