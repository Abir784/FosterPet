<x-app-layout>
<div class="container-fluid" style="margin-left: 100px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">Review Report</h2>
        <a href="{{ route('reports.index') }}" class="btn btn-outline-dark">
            Back to Reports
        </a>
    </div>

    <div class="card">
        <div class="card-body">
                    <!-- Report Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Report Details</h3>
                        <div class="row mb-4">
                        <div class="col-12 mb-3">
                            <div class="d-flex align-items-center">
                                <span class="me-2">Status:</span>
                                <span class="badge {{ $report->status === 'resolved' ? 'bg-success' : 'bg-primary' }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5 class="text-muted mb-2">Reported Message</h5>
                            <p class="border rounded p-3 bg-light">{{ $report->reportedMessage->content }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5 class="text-muted mb-2">Message Author</h5>
                            <p>{{ $report->reportedMessage->sender->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5 class="text-muted mb-2">Reason</h5>
                            <p>{{ $report->reason }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5 class="text-muted mb-2">Description</h5>
                            <p>{{ $report->description ?: 'No additional details provided' }}</p>
                        </div>
                        </div>
                    </div>

                        @if(!$report->response)
                        <!-- Response Form -->
                        <div class="col-12 mt-4">
                            <h4 class="mb-3">Respond to Report</h4>
                            <form action="{{ route('reports.respond', $report) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="action_taken" class="form-label">Action Taken</label>
                                        <select id="action_taken" name="action_taken" class="form-select" required>
                                            <option value="">Select an action</option>
                                            <option value="warning_issued">Warning Issued</option>
                                            <option value="message_deleted">Message Deleted</option>
                                            <option value="no_action_needed">No Action Needed</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="notes" class="form-label">Notes</label>
                                        <textarea id="notes" name="notes" rows="3" class="form-control" required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Submit Response</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @else
                        <!-- Response Details -->
                        <div class="col-12 mt-4 border-top pt-4">
                            <h4 class="mb-3">Response Details</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted mb-2">Action Taken</h5>
                                    <p>{{ str_replace('_', ' ', ucfirst($report->response->action_taken)) }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted mb-2">Responded At</h5>
                                    <p>{{ $report->response->created_at->format('M d, Y H:i') }}</p>
                                </div>
                                <div class="col-12">
                                    <h5 class="text-muted mb-2">Notes</h5>
                                    <p>{{ $report->response->notes }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>
