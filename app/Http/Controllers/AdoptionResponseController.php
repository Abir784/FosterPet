<?php

namespace App\Http\Controllers;

use App\Models\AdoptionRequest;
use App\Models\AdoptionResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdoptionResponseController extends Controller
{
    /**
     * Display a listing of adoption requests that need community input.
     */
    public function index()
    {
        // Get all adoption requests with pending status
        $adoptionRequests = AdoptionRequest::where('status', 'Pending')
            ->with(['adoption.pet', 'adopter', 'responses'])
            ->get();
            
        return view('adoption_responses.index', compact('adoptionRequests'));
    }
    
    /**
     * Show a specific adoption request with its details and responses.
     */
    public function show(AdoptionRequest $adoptionRequest)
    {
        // Load the adoption request with its relationships
        $adoptionRequest->load(['adoption.pet', 'adopter', 'responses.user']);
        
        // Check if the current user has already responded
        $userResponse = $adoptionRequest->responses()
            ->where('user_id', Auth::id())
            ->first();
            
        return view('adoption_responses.show', compact('adoptionRequest', 'userResponse'));
    }
    
    /**
     * Store a new response for an adoption request.
     */
    public function storeResponse(Request $request, AdoptionRequest $adoptionRequest)
    {
        // Validate the request
        $request->validate([
            'comment' => 'required|string|max:500',
            'response' => 'required|in:support,neutral,oppose',
        ]);
        
        // Check if user has already responded
        $existingResponse = $adoptionRequest->responses()
            ->where('user_id', Auth::id())
            ->first();
            
        if ($existingResponse) {
            // Update existing response
            $existingResponse->update([
                'comment' => $request->comment,
                'response' => $request->response,
            ]);
            
            $message = 'Your response has been updated.';
        } else {
            // Create new response
            AdoptionResponse::create([
                'adoption_request_id' => $adoptionRequest->id,
                'user_id' => Auth::id(),
                'comment' => $request->comment,
                'response' => $request->response,
            ]);
            
            $message = 'Your response has been submitted.';
        }
        
        return redirect()->route('adoption-responses.show', $adoptionRequest->id)
            ->with('success', $message);
    }
    
    /**
     * Make a decision on an adoption request based on community responses.
     */
    public function makeDecision(Request $request, AdoptionRequest $adoptionRequest)
    {
        // Validate the request
        $request->validate([
            'decision' => 'required|in:Approved,Rejected',
        ]);
        
        // Only the pet owner can make the final decision
        $petOwnerId = $adoptionRequest->adoption->pet->owner_id;
        
        if (Auth::id() != $petOwnerId) {
            return redirect()->back()->with('error', 'Only the pet owner can make the final decision.');
        }
        
        // Update the adoption request status
        $adoptionRequest->update([
            'status' => $request->decision,
        ]);
        
        $message = 'The adoption request has been ' . strtolower($request->decision) . '.';
        
        return redirect()->route('adoption-responses.index')
            ->with('success', $message);
    }
}
