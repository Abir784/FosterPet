<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests\PetsUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class PetsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function add_pets($id){
        return view('pets.add_pets',[
            'pet_id'=>$id,
        ]);
    }
    public function show_pets(){
        $pets = pets::where('user_id',Auth::id())->get();
        return view("pets.show_pets",[
            'pets'=>$pets,
        ]);
    }

    public function update_pet(PetsUpdateRequest $request): RedirectResponse
    {
        $request->pets()->fill($request->validated());

        if ($request->pets()->isDirty('email')) {
            $request->pets()->email_verified_at = null;
        }

        $request->pets()->save();

        return Redirect::route('pets.add_pets')->with('status', 'pets-info-updated');
    }

    public function destroy_pet(Request $request): RedirectResponse
    {
        $request->validateWithBag('petDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $pets = $request->pets();

        Auth::logout();

        $pets->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
