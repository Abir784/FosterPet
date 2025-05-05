<?php

namespace App\Http\Controllers;

use App\Models\MessageReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageReportController extends Controller
{
    public function store(Request $request)
    {

        try {
            MessageReport::create([
                'reporter_id' => Auth::id(),
                'reported_message_id' => $request->message_id,
                'reason' => $request->reason,
                'description' => $request->description,
                'status' => 'pending'
            ]);

            return back()->with('success', 'Message has been reported successfully.');
        } catch (\Exception $e) {
            return back()->with('success', 'Failed to report message.');
        }
    }
}
