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
        
        return view('index', compact('totalDonations', 'totalAllocations'));
    }
}
