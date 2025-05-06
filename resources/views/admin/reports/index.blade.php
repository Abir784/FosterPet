<x-app-layout>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Reported Messages</div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">Reporter</th>
                            <th class="fw-semibold">Message</th>
                            <th class="fw-semibold">Reason</th>
                            <th class="fw-semibold">Status</th>
                            <th class="fw-semibold">Date</th>
                            <th class="fw-semibold text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr>
                                <td>{{ $report->reporter->name }}</td>
                                <td>
                                    <div class="mb-1">
                                        {{ Str::limit($report->reportedMessage->content, 50) }}
                                    </div>
                                    <small class="text-muted">
                                        By: {{ $report->reportedMessage->sender->name }}
                                    </small>
                                </td>
                                <td><span class="text-capitalize">{{ str_replace('_', ' ', $report->reason) }}</span></td>
                                <td>
                                    <span class="badge {{ $report->status === 'pending' ? 'bg-warning' :
                                        ($report->status === 'resolved' ? 'bg-success' : 'bg-primary') }}">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <td>{{ $report->created_at->format('M d, Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('reports.show', $report) }}"
                                       class="btn btn-sm btn-outline-primary">Review</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
        </div>
    </div></div>
</div>
</x-app-layout>
