<?php

namespace App\Http\Controllers;

use App\Models\ApplicantType;
use App\Models\pets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantTypeController extends Controller
{
    // Show the foster application form
    public function create()
    {
        // Fetch all pets to show in the form
        $pets = pets::all();

        // Return the correct view (matching resources/views/applicant_type.blade.php)
        return view('applicant_type', compact('pets'));
    }

    // Handle the foster application form submission
    public function store(Request $request)
    {
        // Validate the form input
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'foster_type' => 'required|in:short-term,permanent',
        ]);

        // Create a new applicant type record
        ApplicantType::create([
            'user_id' => Auth::id(),
            'pet_id' => $request->pet_id,
            'foster_type' => $request->foster_type,
            'status' => 'pending',
        ]);

        return redirect()->route('applicant-types.create')->with('success', 'Foster application submitted!');
    }
}