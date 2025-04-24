<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdoptionRequest;
use App\Models\pets;

class AdoptionController extends Controller
{
    // Show all adoption requests
    public function adpotion_list()
    {
        $requests = AdoptionRequest::all();
        return view('pet_list', [
            'requests' => $requests,
        ]);
    }

    // Show list of pets to manage adoption status
    public function show_adoption()
    {
        $pets = pets::all();
        return view('adoption_request', ['pets' => $pets]);
    }

    // Update pet's adoption status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Available,Pending,Adopted',
        ]);

        $pet = pets::findOrFail($id);
        $pet->status = $request->status;
        $pet->save();

        return redirect()->route('adoption.status')->with('success', 'Status updated successfully!');
    }
}
