<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdoptionRequest;
use App\Models\pets;
use Illuminate\Support\Facades\Auth;

class AdoptionController extends Controller
{


    public function adoption_list()
    {
        $user = Auth::user();

        $requests = AdoptionRequest::whereHas('adoption.pet', function ($query) use ($user) {
            $query->where('owner_id', $user->id);
        })
        ->with(['adoption.pet', 'adopter'])
        ->get();
        return view('pet_list', [
            'requests' => $requests,
        ]);
    }


    // Update pet's adoption status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Available,Pending,Adopted',
        ]);


        $adoption = AdoptionRequest::where("adoptionID",$id)->update([
            'status' => $request->status,
        ]);

         return back()->with('success', 'Status updated successfully!');
    }

    public function track_adoption(){
        $adoption_requests = AdoptionRequest::where('adopterID', Auth::id())->with('adoption.pet')->get();

        return view('track_adoption', [
            'adoption_requests' => $adoption_requests,
        ]);
    }

    public function show($id)
    {
        $adoptionRequest = AdoptionRequest::with([
            'adoption.pet',
            'adopter',
            'documents',
            'applicantType'
        ])->findOrFail($id);

        return view('adoption.show', compact('adoptionRequest'));
    }
}
