<?php

namespace App\Http\Controllers;

use App\Models\AdoptionRequest;
use App\Models\ApplicantType;
use App\Models\pets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantTypeController extends Controller
{
    // Show the foster application form
    public function create()
    {
        // Get the authenticated user's ID
        $userId = Auth::id();
        
        // Get all adoption requests for this user
        $adoptionRequests = AdoptionRequest::where('adopterID', $userId)
            ->with('adoption.pet')
            ->get();
            
        // Extract the pets from the adoption requests
        $pets = $adoptionRequests->map(function($request) {
            return $request->adoption->pet ?? null;
        })->filter();

        // Return the view with the requested pets
        return view('applicant_type', compact('pets'));
    }

    // Handle the foster application form submission
    public function store(Request $request)
    {
        // Validate the form input
        $validated = $request->validate([
            'adoption_request_id' => 'required|exists:adoption_requests,id',
            'foster_type' => 'required|in:short-term,permanent',
        ]);

        // Verify that the adoption request belongs to the current user
        $adoptionRequest = AdoptionRequest::where('id', $validated['adoption_request_id'])
            ->where('adopterID', Auth::id())
            ->firstOrFail();

        // Create a new applicant type record
        ApplicantType::create([
            'user_id' => Auth::id(),
            'adoption_request_id' => $validated['adoption_request_id'],
            'foster_type' => $validated['foster_type'],
        ]);

        return redirect()->route('applicant-types.create')
            ->with('success', 'Foster application submitted successfully!');
    }
}
