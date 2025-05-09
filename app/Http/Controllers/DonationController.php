<?php

namespace App\Http\Controllers;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\pets;
use Illuminate\Support\Facades\Auth;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class DonationController extends Controller
{

    public function index()
    {
        $donations = Donation::with('allocations')->latest()->paginate(10);
        return view('donations.index', compact('donations'));
    }
    public function create()
    {
        $pets = pets::all();
        return view('donations.donate', compact('pets'));
    }

    public function store(Request $request)
    {
        $messages = [
            'donor_name.required' => 'Please enter your name.',
            'donor_name.max' => 'Name cannot be longer than :max characters.',
            'donor_email.required' => 'Please enter your email address.',
            'donor_email.email' => 'Please enter a valid email address.',
            'amount.required' => 'Please enter the donation amount.',
            'amount.numeric' => 'Amount must be a number.',
            'amount.min' => 'Amount must be at least $:min.',
            'purpose.required' => 'Please select a donation purpose.',
            'donation_type.required' => 'Please select a donation type.',
            'donation_type.in' => 'Please select either one-time or monthly donation.',
            'payment_method.required' => 'Please select a payment method.',
            'payment_method.in' => 'Please select either direct payment or PayPal.',
            'pet_id.exists' => 'The selected pet does not exist.'
        ];

        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'amount' => 'required|numeric|min:1',
            'purpose' => 'required|string|max:255',
            'donation_type' => 'required|in:one-time,monthly',
            'payment_method' => 'required|in:direct,paypal',
            'pet_id' => 'nullable|exists:pets,id'
        ], $messages);

        $transactionId = 'TRX-' . time() . '-' . rand(1000, 9999);

        if ($validated['payment_method'] === 'paypal') {
            // PayPal flow
            try {


                $paypalClient = PayPalService::client();

                $requestOrder = new OrdersCreateRequest();
                $requestOrder->prefer('return=representation');

                $requestOrder->body = [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [[
                        'amount' => [
                            'currency_code' => 'USD',
                            'value' => $validated['amount']
                        ],
                        'description' => 'Donation for: ' . $validated['purpose'],
                    ]],
                    'application_context' => [
                        'cancel_url' => route('donations.cancel'),
                        'return_url' => route('donations.capture', [
                            'donor_name' => $validated['donor_name'],
                            'donor_email' => $validated['donor_email'],
                            'amount' => $validated['amount'],
                            'purpose' => $validated['purpose'],
                            'donation_type' => $validated['donation_type'],
                            'pet_id' => $validated['pet_id'] ?? null
                        ]),
                    ]
                ];

                $response = $paypalClient->execute($requestOrder);


                foreach ($response->result->links as $link) {
                    if ($link->rel === 'approve') {
                        return redirect()->away($link->href);
                    }
                }

                return back()->with('error', 'Unable to connect to PayPal.');
            } catch (\Exception $e) {
                return back()->with('error', 'PayPal payment failed: ' . $e->getMessage());
            }
        }

        // Direct donation flow
        $donation = Donation::create([
            'donor_name' => $validated['donor_name'],
            'donor_email' => $validated['donor_email'],
            'amount' => $validated['amount'],
            'remaining_amount' => $validated['amount'],
            'currency' => 'USD',
            'payment_method' => 'direct',
            'purpose' => $validated['purpose'],
            'donation_type' => $validated['donation_type'],
            'user_id' => auth()->check() ? auth()->id() : null,
            'pet_id' => $validated['pet_id'] ?? null,
            'status' => 'received',
            'transaction_id' => $transactionId
        ]);

        return redirect()->route('donations.success', $donation->id)
            ->with('success', 'Thank you for your donation!');
    }

public function capture(Request $request)
{
    try {
        if (!$request->query('token')) {
            return redirect()->route('donations.cancel')
                ->with('error', 'Invalid payment token.');
        }

        $paypalClient = PayPalService::client();
        $token = $request->query('token');

        $captureRequest = new OrdersCaptureRequest($token);
        $captureRequest->prefer('return=representation');

        $response = $paypalClient->execute($captureRequest);

        if ($response->statusCode === 201) {
            // Payment captured successfully, create donation record
            $transactionId = 'TRX-' . time() . '-' . rand(1000, 9999);
            $donation = Donation::create([
                'donor_name' => $request->query('donor_name'),
                'donor_email' => $request->query('donor_email'),
                'amount' => $request->query('amount'),
                'remaining_amount' => $request->query('amount'),
                'currency' => 'USD',
                'payment_method' => 'paypal',
                'purpose' => $request->query('purpose'),
                'donation_type' => $request->query('donation_type', 'one-time'),
                'pet_id' => $request->query('pet_id') ? intval($request->query('pet_id')) : null,
                'status' => 'received',
                'transaction_id' => $transactionId
            ]);

            return redirect()->route('donations.success', $donation->id)
                ->with('success', 'Thank you for your PayPal donation!');
        }

        return redirect()->route('donations.cancel')
            ->with('error', 'Payment was not completed.');
    } catch (\Exception $e) {
        return redirect()->route('donations.cancel')
            ->with('error', 'An error occurred while processing your payment: ' . $e->getMessage());
    }
}



    public function success($donationId)
    {
        $donation = Donation::findOrFail($donationId);
        return view('donations.success', ['donation' => $donation]);
    }

    public function cancel()
    {
        return view('donations.cancel');
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
