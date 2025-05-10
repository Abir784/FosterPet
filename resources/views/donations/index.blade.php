<x-app-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">🎁 Donation Tracking</h2>

        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Donor</th>
                                        <th>Amount</th>
                                        <th>Purpose</th>
                                        <th>Status</th>
                                        <th>Remaining</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($donations as $donation)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $donation->donor_name }}</strong>
                                                    @if($donation->donor_email)
                                                        <br>
                                                        <small class="text-muted">{{ $donation->donor_email }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ $donation->currency }} {{ number_format($donation->amount, 2) }}
                                                </span>
                                            </td>
                                            <td>{{ $donation->purpose ?? 'General Fund' }}</td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'received' => 'info',
                                                        'allocated' => 'primary',
                                                        'completed' => 'success'
                                                    ];
                                                    $color = $statusColors[$donation->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $color }}">
                                                    {{ ucfirst($donation->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    @php
                                                        $percentage = ($donation->remaining_amount / $donation->amount) * 100;
                                                    @endphp
                                                    <div class="progress-bar bg-info" role="progressbar"
                                                         style="width: {{ $percentage }}%;"
                                                         aria-valuenow="{{ $percentage }}"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100">
                                                        {{ number_format($donation->remaining_amount, 2) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('donations.show', $donation) }}"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="text-muted">
                                                    No donations found.
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    {{ $donations->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
