<?php

namespace App\Http\Controllers;

// use App\Models\User;

use App\Models\AdoptionRequest;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use App\Models\pets;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
class AdoptionController extends Controller
{
    function adpotion_list(){
        $requests=AdoptionRequest::all();
        return view('pet_list',[
         'requests'=>$requests,
        ]);
    }
    public function show_adoption(){
        $pets = AdoptionRequest::where('adoptionID')->get();
       // return view("adoption_request",
         //   );
            return view('adoption_request', ['pets' => $pets]);

    }

    public function updateStatus(Request $request, $id)
{
    $pet = pets::findOrFail($id);
    $pet->status = $request->status;
    $pet->save();

    return redirect()->route('track.requests')->with('success', 'Status updated successfully!');
}
}
