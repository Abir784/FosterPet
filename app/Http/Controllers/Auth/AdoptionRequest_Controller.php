<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdoptionRequest;

class AdoptionRequestController extends Controller
{
    // Show the pet list with status options
    public function index()
    {
        $pets = AdoptionRequest::all(); // Get all pets
        return view('adoption_requests', compact('pets'));
    }

    // Update the pet's status
    public function updateStatus(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'status' => 'required|in:Available,Pending,Adopted',
        ]);

        // Find the pet
        $pet = AdoptionRequest::findOrFail($id);

        // Update status
        $pet->status = $request->status;
        $pet->save();

        return redirect()->route('adoption.index')->with('success', 'Pet status updated!');
    }
}
