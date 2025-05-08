<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationAllocation;
use App\Models\pets;
use App\Models\AdoptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    function index() {
        $totalDonations = Donation::sum('amount');
        $totalAllocations = DonationAllocation::where('status', 'approved')->sum('amount');

        // Get allocation breakdown by type
        $allocationTypes = DonationAllocation::where('status', 'approved')
            ->select('allocation_type', \DB::raw('SUM(amount) as total'))
            ->groupBy('allocation_type')
            ->get()
            ->pluck('total', 'allocation_type')
            ->toArray();

        // Sort allocation types by amount (descending)
        arsort($allocationTypes);

        // Get all pets that are available for adoption with their adoption records
        $pets = pets::whereHas('adoption')->with('adoption')->get();

        // If user is logged in and is an adopter, get their existing adoption requests
        $userRequests = [];
        if (Auth::check() && Auth::user()->role === 'adopter') {
            $userRequests = AdoptionRequest::where('adopterID', Auth::id())
                ->pluck('adoptionID')
                ->toArray();
        }

        return view('index', compact('totalDonations', 'totalAllocations', 'allocationTypes', 'pets', 'userRequests'));
    }
}
