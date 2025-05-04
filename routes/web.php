<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PetsController;
use App\Models\AdoptionRequest;
use App\Models\pets;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('index');
});

// Dashboard

Route::get('/dashboard', function () {
    $pet_count = pets::where('owner_id', Auth::id())->count();
    $adoption_request_count = AdoptionRequest::whereIn('adoptionID', function($query) {
        $query->select('id')
            ->from('pets')
            ->where('owner_id', Auth::id());
    })->count();
    return view('dashboard', [
        'pet_count' => $pet_count,
        'adoption_request_count' => $adoption_request_count,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pets
    Route::get('/pets/add', [PetsController::class, 'add_pets'])->name('pets.add_pets');
    Route::post('/pets/store', [PetsController::class, 'add_pets_post'])->name('add_pets.post');

    Route::post('/pets/update', [PetsController::class, 'update_pets'])->name('pets.update_pet');
    Route::delete('/pets/delete', [PetsController::class, 'destroy_pet'])->name('pets.destroy_pet');
    Route::get("/pets/details",[PetsController::class,"show_pets"])->name('show.pets');
    Route::get("/pets/adopt/show",[AdoptionController::class,"adoption_list"])->name('track.requests');
    Route::get('/pets/details', [PetsController::class, 'show_pets'])->name('show.pets');

    // Adoption
    Route::get('/pets/adopt/show', [AdoptionController::class, 'adpotion_list'])->name('track.requests');
    Route::get('/adoption/status', [AdoptionController::class, 'updateStatus'])->name('adoption.status');
    Route::post('/adoption/update/{id}', [AdoptionController::class, 'updateStatus'])->name('adoption.update');

    // Add this route to fix the "adoption.index not defined" error
    Route::get('/adoption', [AdoptionController::class, 'show_adoption'])->name('adoption.index');
    //Tracking Adoption Requests
    Route::get('/adoption/track', [AdoptionController::class, 'track_adoption'])->name('adoption.track');
});

require __DIR__.'/auth.php';
