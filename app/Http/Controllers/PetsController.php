<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PetsUpdateRequest;
use App\Models\pets;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class PetsController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function add_pets(){
        return view('pets.add_pets');
    }


    public function show_pets(){
        $pets = pets::where('user_id',Auth::id())->get();
        return view("pets.show_pets",[
            'pets'=>$pets,
        ]);
    }

    public function update_pets(Request $request){
        // print_r($request->all());

         $request->validate(
             [
                 'name' => 'required',
                 'age' => 'required',
                 'breed' => 'required',
                 'location' => 'required',
                 'health condition' => 'required',
             ],
             [
                 'name.required' => 'Name is required',
                 'age.required' => 'Age is required',
                 'breed.required' => 'Breed is required',
                 'location.required' => 'location is required',
                 'health condition' => 'health condition is required'
                 //'phone_number.numeric' => 'Phone number must be numeric',
             ]
             );
            pets::where('id',Auth::user()->id)->update([
             'name' => $request->name,
             'location' => $request->location,
             'color' => $request->color,
             'breed' => $request->breed,
             'health condition' => $request->health_condition,
             'updated_at' => Carbon::now(),
            ]);// id check kore



            return back()->with('success','Pets Updated Successfully');
           // return redirect()->route('profile_update')->with('success','Profile Updated Successfully');

     }


    public function destroy_pet($id){
        pets::find($id)->delete();
        return back()->with('success','Deleted Successfully');
    }

    public function add_pets_post(Request $request){
        // echo $request->location."<br>";
        // echo $request->health."<br>";
        // echo $request->color."<br>";
        // echo $request->breed."<br>";
        // echo $request->name."<br>";
        // die();
        //$request->validate([
    //         'name' => 'required|string|max:255',
    //         'age' => 'required|integer|min:0',
    //         'breed' => 'required|string|max:255',
    //         'color' => 'required|string|max:255',
    //         'health_condition' => 'required|string|max:255',
    //         'temperament' => 'required|string|max:255',
            // 'location' => 'required|string|max:255',
            // 'remarks' => 'required|string|max:255',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
    // ]);


    // $imagePath = null;
    // if ($request->hasFile('image')) {
    //     $image = $request->file('image');
    //     $imageName = time() . '_' . $image->getClientOriginalName();
    //     $imagePath = $image->storeAs('pets', $imageName, 'public');
    // }
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
        pets::create([
            'name' => $request->name,
            'age' => $request->age,
            'breed' => $request->breed,
            'health_condition' => $request->health,
            'temperament' => $request->temperament,
            'color' => $request->color,
            'location' => $request->location,
            'remarks' => $request->remarks,
            'owner_id' => 1,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Pet information saved successfully!');
    }

}



    