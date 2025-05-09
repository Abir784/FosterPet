<?php

namespace App\Http\Controllers;

use App\Models\pets;
use App\Models\AdoptionRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [
            'user_role' => $user->role
        ];

        if ($user->role === 'pet shelter') {
            $data['pet_count'] = pets::where('owner_id', Auth::id())->count();
            $data['adoption_request_count'] = AdoptionRequest::whereIn('adoptionID', function($query) {
                $query->select('id')
                    ->from('pets')
                    ->where('owner_id', Auth::id());
            })->count();
            $data['pending_requests'] = AdoptionRequest::whereIn('adoptionID', function($query) {
                $query->select('id')
                    ->from('pets')
                    ->where('owner_id', Auth::id());
            })->where('status', 'pending')->count();
        } elseif ($user->role === 'adopter') {
            $data['submitted_requests'] = AdoptionRequest::where('AdopterId', Auth::id())->count();
            $data['pending_requests'] = AdoptionRequest::where('AdopterId', Auth::id())
                ->where('status', 'pending')->count();
            $data['approved_requests'] = AdoptionRequest::where('AdopterId', Auth::id())
                ->where('status', 'approved')->count();
        }

        return view('dashboard', $data);
    }
}
