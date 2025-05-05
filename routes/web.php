<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MessageReportController;
use App\Http\Controllers\Admin\ReportManagementController;
use App\Http\Controllers\PetsController;
use App\Http\Controllers\ApplicantTypeController;
use App\Http\Controllers\FriendRequestController;
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

    Route::get('/reports', [\App\Http\Controllers\Admin\ReportManagementController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [\App\Http\Controllers\Admin\ReportManagementController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/respond', [\App\Http\Controllers\Admin\ReportManagementController::class, 'respond'])->name('reports.respond');
    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/unread-count', [MessageController::class, 'getUnreadCount'])->name('messages.unread-count');

    // Documents
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');


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

    // Applicant Types (Foster Application)
    Route::get('/foster/apply', [ApplicantTypeController::class, 'create'])->name('applicant-types.create'); // Show foster application form
    Route::post('/foster/apply', [ApplicantTypeController::class, 'store'])->name('applicant-types.store'); // Submit foster application

    Route::get('/friends', [FriendRequestController::class, 'index'])->name('friends.index');
    Route::post('/friend-request/send', [FriendRequestController::class, 'send'])->name('friends.send');
    Route::post('/friend-request/accept/{id}', [FriendRequestController::class, 'accept'])->name('friends.accept');
    Route::post('/friend-request/decline/{id}', [FriendRequestController::class, 'decline'])->name('friends.reject');
    // Route::get('/friends', [FriendRequestController::class, 'myFriends']);

    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/message/send', [MessageController::class, 'send'])->name('message.send');
    Route::get('/message/conversation/{userId}', [MessageController::class, 'conversation'])->name('message.conversation');
    Route::post('/message/report', [MessageReportController::class, 'store'])->name('message.report');
});

require __DIR__.'/auth.php';
