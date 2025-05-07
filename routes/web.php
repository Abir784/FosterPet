<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PetsController;
use App\Http\Controllers\ApplicantTypeController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\AdoptionResponseController;
use App\Models\AdoptionRequest;
use App\Models\pets;
use Illuminate\Support\Facades\Auth;



Route::get('/',[MainController::class,'index'])->name('index');



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

    Route::get("/pets/update_form",[PetsController::class, "update_form"])->name('pets.update_form');
    Route::post('/pets/update_post', [PetsController::class, 'update_pets'])->name('pets.update_pet');
    Route::delete('/pets/delete', [PetsController::class, 'destroy_pet'])->name('pets.destroy_pet');
    Route::get("/pets/details",[PetsController::class,"show_pets"])->name('show.pets');
    Route::get("/pets/adopt/show",[AdoptionController::class,"adoption_list"])->name('track.requests');
    Route::get('/pets/details', [PetsController::class, 'show_pets'])->name('show.pets');

    // Adoption
    Route::get('/adoption/status', [AdoptionController::class, 'updateStatus'])->name('adoption.status');
    Route::post('/adoption/update/{id}', [AdoptionController::class, 'updateStatus'])->name('adoption.update');

    // Add this route to fix the "adoption.index not defined" error
    Route::get('/adoption', [AdoptionController::class, 'show_adoption'])->name('adoption.index');
    //Adopter
    Route::get('/adoption/track', [AdoptionController::class, 'track_adoption'])->name('adoption.track');
    
    // Adoption Responses - Community Input System
    Route::get('/adoption-responses', [AdoptionResponseController::class, 'index'])->name('adoption-responses.index');
    Route::get('/adoption-responses/{adoptionRequest}', [AdoptionResponseController::class, 'show'])->name('adoption-responses.show');
    Route::post('/adoption-responses/{adoptionRequest}/respond', [AdoptionResponseController::class, 'storeResponse'])->name('adoption-responses.respond');
    Route::post('/adoption-responses/{adoptionRequest}/decision', [AdoptionResponseController::class, 'makeDecision'])->name('adoption-responses.decision');

    // Applicant Types (Foster Application)
    Route::get('/foster/apply', [ApplicantTypeController::class, 'create'])->name('applicant-types.create'); // Show foster application form
    Route::post('/foster/apply', [ApplicantTypeController::class, 'store'])->name('applicant-types.store'); // Submit foster application

    Route::get('/friends', [FriendRequestController::class, 'index'])->name('friends.index');
    Route::post('/friend-request/send', [FriendRequestController::class, 'send'])->name('friends.send');
    Route::post('/friend-request/accept/{id}', [FriendRequestController::class, 'accept'])->name('friends.accept');
    Route::post('/friend-request/decline/{id}', [FriendRequestController::class, 'decline'])->name('friends.reject');
    // Route::get('/friends', [FriendRequestController::class, 'myFriends']);

    // Messages
    // Route::post('/message/send', [MessageController::class, 'send']);
    // Route::get('/message/conversation/{userId}', [MessageController::class, 'conversation'])
});

require __DIR__.'/auth.php';
