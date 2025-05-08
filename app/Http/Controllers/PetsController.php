<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PetsUpdateRequest;
use App\Models\Adoption;
use App\Models\AdoptionRequest;
use App\Models\pets;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class PetsController extends Controller
{

    public function add_pets(){
        return view('pets.add_pets');
    }

    public function show_all_pets(){
        $pets = pets::all();//all for showing
        return view("pets.show_pets",[
            'pets'=>$pets,
        ]);
    }

    public function update_form($id){
        // Find the pet and ensure it belongs to the current user
        $pet = pets::where('id', $id)
                    ->where('owner_id', Auth::id())
                    ->first();

        if (!$pet) {
            return back()->with('error', 'Pet not found or unauthorized');
        }

        return view("pets.update_pets", [
            "pet" => $pet
        ]);
    }
    public function show_pets(){
        $pets = pets::where('owner_id',Auth::id())->get();
        return view("pets.show_pets",[
            'pets'=>$pets,
        ]);
    }

    public function show_pet($id)
    {
        $pet = pets::with(['adoption'])->findOrFail($id);
        return view('pets.show_pet', compact('pet'));
    }
    

    public function update_pets(Request $request){
        // print_r($request->all());
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:Dog,Cat,Bird,Fish,Other',
            'age' => 'required',
            'breed' => 'required',
            'location' => 'required',
            'health_condition' => 'required',
        ], [
            'name.required' => 'Name is required',
            'type.required' => 'Type is required',
            'type.in' => 'Please select a valid pet type',
            'age.required' => 'Age is required',
            'breed.required' => 'Breed is required',
            'location.required' => 'Location is required',
            'health_condition.required' => 'Health condition is required'
        ]);


        // Get the pet ID from the URL parameter
        $petId = $request->route('id');

        // Find the pet and check if it belongs to the current user
        $pet = pets::where('id', $petId)
                    ->where('owner_id', Auth::id())
                    ->first();

        if (!$pet) {
            return back()->with('error', 'Pet not found or unauthorized');
        }

        // Update the pet details
        $pet->update([
            'name' => $request->name,
            'age' => $request->age,
            'type' => $request->type,
            'location' => $request->location,
            'color' => $request->color,
            'breed' => $request->breed,
            'health_condition' => $request->health_condition,
            'updated_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Pet details updated successfully');

     }


    public function destroy_pet($id) {
        // Find the pet and ensure it belongs to the current user
        $pet = pets::where('id', $id)
                    ->where('owner_id', Auth::id())
                    ->first();

        if (!$pet) {
            return back()->with('error', 'Pet not found or unauthorized');
        }

        // Delete the pet
        $pet->delete();

        // Redirect back to pets list with success message
        return redirect()->route('show.pets')->with('success', 'Pet deleted successfully');
    }

    public function add_pets_post(Request $request){

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'age' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'health_condition' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'remarks' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'temperament' => 'required|string|max:255',
            'image' => 'nullable',
        ]);


        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagepath = public_path('pets');

            // Create the pets folder if it doesn't exist
            if (!file_exists($imagepath)) {
                mkdir($imagepath, 0755, true);
            }

            // Move the uploaded file to public/pets
            $image->move($imagepath, $imageName);

            // Relative path to access via browser (e.g., /pets/image.jpg)
            $imagePath = 'pets/' . $imageName;
        }



       // ]);
        $pet=pets::create([
            'name' => $request->name,
            'type' => $request->type,
            'age' => $request->age,
            'breed' => $request->breed,
            'health_condition' => $request->health_condition,
            'temperament' => $request->temperament,
            'color' => $request->color,
            'location' => $request->location,
            'remarks' => $request->remarks,
            'owner_id' =>Auth::id(),
            'image' => $imagePath,
        ]);

        Adoption::create([
            'pet_id' => $pet->id,
            'created_at' => Carbon::now(),
        ]);


        return back()->with('success', 'Pet information saved successfully!');
    }

}



