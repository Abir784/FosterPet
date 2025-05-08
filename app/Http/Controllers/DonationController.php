<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index()
    {
        // If user is logged in, show all donations with a tab for their donations
        if (Auth::check()) {
            $allDonations = Donation::with('allocations')->latest()->paginate(10, ['*'], 'all_page');
            $userDonations = Donation::where('user_id', Auth::id())
                ->with('allocations')
                ->latest()
                ->paginate(10, ['*'], 'user_page');
            
            // Also set $donations to $allDonations for compatibility with the view
            $donations = $allDonations;
                
            return view('donations.index', compact('allDonations', 'userDonations', 'donations'));
        } else {
            // For guests, just show all donations
            $donations = Donation::with('allocations')->latest()->paginate(10);
            return view('donations.index', compact('donations'));
        }
    }
    
    /**
     * Display the user's donations and their allocations.
     */
    public function userDonations()
    {
        // Get user donations with allocations
        $donations = Auth::user()->donations()
            ->with(['allocations' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->latest()
            ->paginate(10);
            
        // Calculate total donated amount
        $totalDonated = Auth::user()->donations()->sum('amount');
        
        // Calculate total allocated amount more efficiently
        $totalAllocated = DonationAllocation::whereIn('donation_id', Auth::user()->donations()->pluck('id'))
            ->sum('amount');
        
        // Get allocation breakdown by type
        $allocationTypes = DonationAllocation::whereIn('donation_id', Auth::user()->donations()->pluck('id'))
            ->select('allocation_type', \DB::raw('SUM(amount) as total'))
            ->groupBy('allocation_type')
            ->get()
            ->pluck('total', 'allocation_type')
            ->toArray();
        
        // Sort allocation types by amount (descending)
        arsort($allocationTypes);
        
        // Get allocations grouped by donation
        $donationAllocations = [];
        foreach ($donations as $donation) {
            $donationAllocations[$donation->id] = [
                'donation' => $donation,
                'allocations' => $donation->allocations->groupBy('allocation_type')
            ];
        }
            
        return view('donations.user.index', compact('donations', 'totalDonated', 'totalAllocated', 'allocationTypes', 'donationAllocations'));
    }
    public function show(Donation $donation)
    {
        $donation->load(['allocations.approver']);
        return view('donations.show', compact('donation'));
    }

    public function createDemoData()
    {
        // Create demo donations
        $donations = [
            [
                'donor_name' => 'John Doe',
                'donor_email' => 'john@example.com',
                'amount' => 1000.00,
                'payment_method' => 'Credit Card',
                'transaction_id' => 'TRX' . time() . '1',
                'purpose' => 'General pet care and medical expenses',
                'remaining_amount' => 1000.00,
                'status' => 'received'
            ],
            [
                'donor_name' => 'Jane Smith',
                'donor_email' => 'jane@example.com',
                'amount' => 500.00,
                'payment_method' => 'PayPal',
                'transaction_id' => 'TRX' . time() . '2',
                'purpose' => 'Emergency medical fund',
                'remaining_amount' => 500.00,
                'status' => 'received'
            ]
        ];

        foreach ($donations as $donationData) {
            Donation::create($donationData);
        }

        return redirect()->route('donations.index')
            ->with('success', 'Demo donations created successfully');
    }

    public function allocate(Request $request, Donation $donation)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01', 'max:' . $donation->remaining_amount],
            'allocated_to' => 'required|string',
            'allocation_type' => 'required|string',
            'description' => 'required|string'
        ]);

        $allocation = $donation->allocations()->create([
            'allocated_to' => $request->allocated_to,
            'allocation_type' => $request->allocation_type,
            'amount' => $request->amount,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        // Update remaining amount
        $donation->remaining_amount -= $request->amount;
        if ($donation->remaining_amount <= 0) {
            $donation->status = 'allocated';
        }
        $donation->save();

        return redirect()->route('donations.show', $donation)
            ->with('success', 'Allocation created successfully');
    }

    public function approveAllocation(DonationAllocation $allocation)
    {
        $allocation->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);

        // Check if all allocations are approved
        $donation = $allocation->donation;
        if ($donation->allocations()->where('status', '!=', 'approved')->count() === 0) {
            $donation->update(['status' => 'completed']);
        }

        return redirect()->back()->with('success', 'Allocation approved successfully');
    }

}
