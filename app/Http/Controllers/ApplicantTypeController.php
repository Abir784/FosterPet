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

        // Get the IDs of adoption requests that already have an applicant type
        $existingAppIds = ApplicantType::where('user_id', $userId)
            ->pluck('adoption_request_id')
            ->toArray();

        // Filter out adoption requests that already have an applicant type
        $filteredRequests = $adoptionRequests->reject(function ($request) use ($existingAppIds) {
            return in_array($request->id, $existingAppIds) || !isset($request->adoption->pet);
        });

        // Extract the pets from the filtered adoption requests
        $pets = $filteredRequests->map(function($request) {
            return $request->adoption->pet;
        })->filter();

        // Return the view with the requested pets
        return view('applicant_type', compact('pets'));
    }

    // Handle the foster application form submission
    public function store(Request $request)
    {
        // Validate the common form input
        $validated = $request->validate([
            'adoption_request_id' => 'required|exists:adoption_requests,id',
            'foster_type' => 'required|in:short-term,permanent',
        ]);

        // Additional validation based on foster type
        if ($validated['foster_type'] === 'short-term') {
            $additionalValidation = $request->validate([
                'duration' => 'required|integer|min:1',
                'temporary_address' => 'required|string|max:255',
            ]);
        } else {
            $additionalValidation = $request->validate([
                'employment_status' => 'required|string|max:255',
                'housing_status' => 'required|string|max:255',
            ]);
        }

        // Merge the validation results
        $validated = array_merge($validated, $additionalValidation);

        try {
            // Create a new applicant type record
            $applicantType = new ApplicantType([
                'user_id' => Auth::id(),
                'adoption_request_id' => $validated['adoption_request_id'],
                'foster_type' => $validated['foster_type'],
            ]);


            // Set fields based on foster type
            if ($validated['foster_type'] === 'short-term') {
                $applicantType->duration = $validated['duration'];
                $applicantType->temporary_address = $validated['temporary_address'];
            } else {
                $applicantType->employment_status = $validated['employment_status'];
                $applicantType->housing_status = $validated['housing_status'];
            }

            $applicantType->save();

            return redirect()->route('applicant-types.create')
                ->with('success', 'Foster application submitted successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error submitting application: ' . $e->getMessage());
        }
    }
}
