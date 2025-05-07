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
        $donations = Donation::with('allocations')->latest()->paginate(10);
        return view('donations.index', compact('donations'));
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
