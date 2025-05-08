<?php

namespace App\Http\Controllers;

use App\Models\AdoptionRequest;
use App\Models\Adoption;
use App\Models\pets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdoptionRequestController extends Controller
{
    public function store(Request $request, $petId)
    {
        // Validate that the user has the role "adopter"
        if (Auth::user()->role !== 'adopter') {
            return back()->with('error', 'Only adopters can request to adopt pets');
        }

        // Validate request data
        $request->validate([
            'adoption_id' => 'required|exists:adoptions,id'
        ]);

        // Check if pet exists and is available
        $pet = pets::findOrFail($petId);

        // Check if the adoption record belongs to this pet
        $adoption = Adoption::where('id', $request->adoption_id)
            ->where('pet_id', $petId)
            ->firstOrFail();

        // Check if user already has a pending request for this pet
        $existingRequest = AdoptionRequest::where('adopterID', Auth::id())
            ->where('adoptionID', $request->adoption_id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'You already have a pending request for this pet');
        }



    
        // Create adoption request
        AdoptionRequest::create([
            'adoptionID' => $request->adoption_id,
            'adopterID' => Auth::id(),
            'status' => 'pending'
        ]);




        return back()->with('success', 'Adoption request submitted successfully');
    }


}
