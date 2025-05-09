<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Begin transaction to ensure all related data is deleted
        \DB::beginTransaction();
        
        try {
            // Delete all adoption requests made by this user
            $user->adoptionRequests()->delete();
            
            // If user is a pet shelter, delete all their pets
            if ($user->role === 'pet shelter') {
                // Get all pets to delete their images
                $pets = $user->pets()->get();
                foreach ($pets as $pet) {
                    // Delete pet image if exists
                    if ($pet->image && file_exists(public_path($pet->image))) {
                        unlink(public_path($pet->image));
                    }
                }
                $user->pets()->delete();
            }
            
            // Delete all messages
            $user->messages()->delete();
            $user->receivedMessages()->delete();
            
            // Delete all message reports
            $user->messageReports()->delete();
            
            // Delete all friend requests
            $user->sentFriendRequests()->delete();
            $user->receivedFriendRequests()->delete();
            
            // Delete all donations
            $user->donations()->delete();
            
            // Delete all documents
            $documents = $user->documents()->get();
            foreach ($documents as $document) {
                if ($document->file_path && file_exists(storage_path('app/' . $document->file_path))) {
                    unlink(storage_path('app/' . $document->file_path));
                }
            }
            $user->documents()->delete();
            
            // Finally delete the user
            Auth::logout();
            $user->delete();
            
            \DB::commit();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return Redirect::to('/')->with('success', 'Your account and all associated data have been permanently deleted.');
            
        } catch (\Exception $e) {
            \DB::rollBack();
            return Redirect::back()->withErrors(['error' => 'Failed to delete account. Please try again.']);
        }
    }
}
