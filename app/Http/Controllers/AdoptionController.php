<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdoptionRequest;
use App\Models\pets;

class AdoptionController extends Controller
{

    function adoption_list(){
        $requests=AdoptionRequest::all();
        return view('pet_list',[
         'requests'=>$requests,
        ]);
    }
    // Show all adoption requests
    public function adpotion_list()
    {
        $requests = AdoptionRequest::all();
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
}
