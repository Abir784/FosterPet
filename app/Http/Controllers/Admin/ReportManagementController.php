<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MessageReport;
use App\Models\ReportResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReportManagementController extends Controller
{
    public function index()
    {
        $reports = MessageReport::with(['reporter', 'reportedMessage', 'reportedMessage.sender'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.reports.index', compact('reports'));
    }

    public function show(MessageReport $report)
    {
        $report->load(['reporter', 'reportedMessage', 'reportedMessage.sender', 'response']);
        return view('admin.reports.show', compact('report'));
    }

    public function respond(Request $request, MessageReport $report)
    {
        $validated = $request->validate([
            'response_content' => 'required|string|max:1000',
            'action_taken' => 'required|string|max:255',
        ]);

        $response = ReportResponse::create([
            'report_id' => $report->id,
            'admin_id' => Auth::id(),
            'response_content' => $validated['response_content'],
            'action_taken' => $validated['action_taken'],
        ]);

        $report->update(['status' => 'resolved']);

        // Send email to the reporter
        Mail::to($report->reporter->email)->send(new \App\Mail\ReportResponseMail($report, $response));

        return back()->with('success', 'Response sent successfully.');
    }
}
