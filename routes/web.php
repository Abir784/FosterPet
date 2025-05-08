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
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AdoptionRequestController;
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

// Pet Details
Route::get('/pet/{id}', [PetsController::class, 'show_pet'])->name('pet.show');

// Public Donation Routes
Route::get('/donate', [DonationController::class, 'create'])->name('donations.create');
Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
Route::get('/donations/capture', [DonationController::class, 'capture'])->name('donations.capture');
Route::get('/donation/success/{id}', [DonationController::class, 'success'])->name('donations.success');
Route::get('/donation/cancel', [DonationController::class, 'cancel'])->name('donations.cancel');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Adoption Request
    Route::post('/adoption-request/{pet}', [AdoptionRequestController::class, 'store'])->name('adoption.request');

    Route::get('/reports', [\App\Http\Controllers\Admin\ReportManagementController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [\App\Http\Controllers\Admin\ReportManagementController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/respond', [\App\Http\Controllers\Admin\ReportManagementController::class, 'respond'])->name('reports.respond');
    // Donations
    Route::prefix('donations')->group(function () {
    Route::get('/', [DonationController::class, 'index'])->name('donations.index');
    Route::get('/my-donations', [DonationController::class, 'userDonations'])->name('donations.user');
    Route::get('/demo-data', [DonationController::class, 'createDemoData'])->name('donations.demo');
    Route::get('/{donation}', [DonationController::class, 'show'])->name('donations.show');
    Route::post('/{donation}/allocate', [DonationController::class, 'allocate'])->name('donations.allocate');
    Route::post('/allocation/{allocation}/approve', [DonationController::class, 'approveAllocation'])->name('donations.approve-allocation');
});

Route::get('/donations/capture', [DonationController::class, 'capture'])->name('donations.capture');
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

    Route::get("/pets/update_form/{id}",[PetsController::class, "update_form"])->name('pets.update_form');

    Route::post('/pets/update_post/{id}', [PetsController::class, 'update_pets'])->name('pets.update_pet');
    Route::delete('/pets/delete/{id}', [PetsController::class, 'destroy_pet'])->name('pets.destroy_pet');
    Route::get("/pets/details",[PetsController::class,"show_pets"])->name('show.pets');
    Route::get('/pets/all', [PetsController::class, 'show_all_pets'])->name('show.all.pets');
    Route::get("/pets/adopt/show",[AdoptionController::class,"adoption_list"])->name('track.requests');

    // Adoption Routes
    Route::prefix('adoption')->group(function () {
        Route::get('/track', [AdoptionController::class, 'track_adoption'])->name('adoption.track');
        Route::get('/status', [AdoptionController::class, 'updateStatus'])->name('adoption.status');
        Route::post('/update/{id}', [AdoptionController::class, 'updateStatus'])->name('adoption.update');
        Route::get('/{id}', [AdoptionController::class, 'show'])->name('adoption.show');
        // Add this route to fix the "adoption.index not defined" error
        Route::get('/', [AdoptionController::class, 'show_adoption'])->name('adoption.index');
    });

    // Add this route to fix the "adoption.index not defined" error
    Route::get('/adoption', [AdoptionController::class, 'show_adoption'])->name('adoption.index');
    //Adopter
    Route::get('/adoption/track', [AdoptionController::class, 'track_adoption'])->name('adoption.track');


    // Adoption Routes
    Route::prefix('adoption')->group(function () {
        Route::get('/track', [AdoptionController::class, 'track_adoption'])->name('adoption.track');
        Route::get('/status', [AdoptionController::class, 'updateStatus'])->name('adoption.status');
        Route::post('/update/{id}', [AdoptionController::class, 'updateStatus'])->name('adoption.update');
        Route::get('/{id}', [AdoptionController::class, 'show'])->name('adoption.show');
    });


    // Applicant Types (Foster Application)
    Route::get('/foster/apply', [ApplicantTypeController::class, 'create'])->name('applicant-types.create'); // Show foster application form
    Route::post('/foster/apply', [ApplicantTypeController::class, 'store'])->name('applicant-types.store'); // Submit foster application

    // User Management Routes
    Route::get('/users/manage', [ApplicantTypeController::class, 'manageUsers'])->name('users.manage');
    Route::get('/users/{user}/edit', [ApplicantTypeController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [ApplicantTypeController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [ApplicantTypeController::class, 'deleteUser'])->name('users.delete');

    Route::get('/friends', [FriendRequestController::class, 'index'])->name('friends.index');
    Route::post('/friend-request/send', [FriendRequestController::class, 'send'])->name('friends.send');
    Route::post('/friend-request/accept/{id}', [FriendRequestController::class, 'accept'])->name('friends.accept');
    Route::post('/friend-request/decline/{id}', [FriendRequestController::class, 'decline'])->name('friends.reject');

    // Messages

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/message/send', [MessageController::class, 'send'])->name('message.send');
    Route::get('/message/conversation/{userId}', [MessageController::class, 'conversation'])->name('message.conversation');
    Route::post('/message/report', [MessageReportController::class, 'store'])->name('message.report');
});

require __DIR__.'/auth.php';
