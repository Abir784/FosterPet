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

    public function donation_form_post(Request $request){
        $campaign=Campaign::select('title','goal','goal_raised','added_by')->where('id',$request->campaign_id)->first();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'city' => 'required',
            'zipcode' => 'required',
            'donation_amount' => 'required|numeric|max:'.($campaign-> goal - $campaign->goal_raised),
            ],[
                'donation_amount.max'=>'You can donate up to '.($campaign->goal - $campaign->goal_raised),
            ]);

        if(($campaign-> goal - $campaign->goal_raised) < ($request->donation_amount)){
            return back()->with('error','Please Check The Required Goal');
        }else{
            //all existing code
            Donation::create([
                'user_id'=>$request->user_id,
                'campaign_id'=>$request->campaign_id,
                'name'=>$request->name,
                'email'=>$request->email,
                'city'=>$request->city,
                'zipcode'=>$request->zipcode,
                'donation_amount'=>$request->donation_amount,
                'payment_status'=>0,
                'created_at'=>Carbon::now(),
            ]);

            $details =[
                'name'=>Auth::user()->name,
                'amount'=>$request->donation_amount,
                'title'=>$campaign->title,
            ];
            $email=$campaign->posted_by->email;

            Notification::route('mail',$email)->notify(new NotifyMe($details));

            return redirect(route('paypal.payment',['amount'=>$request->donation_amount,
            'campaign_id'=>$request->campaign_id,
        ]));

        }

}

}

    