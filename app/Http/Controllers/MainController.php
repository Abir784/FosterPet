<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationAllocation;
use Illuminate\Http\Request;

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
        
        return view('index', compact('totalDonations', 'totalAllocations', 'allocationTypes'));
    }
}
