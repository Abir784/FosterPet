<x-app-layout>
    <div class="container py-4">
        <div class="mb-4">
            <a href="{{ route('donations.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Donations
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Donation Details -->
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title h5 mb-0">Donation Details</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Donor</dt>
                            <dd class="col-sm-8">
                                {{ $donation->donor_name }}
                                @if($donation->donor_email)
                                    <br>
                                    <small class="text-muted">{{ $donation->donor_email }}</small>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Amount</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-success">
                                    {{ $donation->currency }} {{ number_format($donation->amount, 2) }}
                                </span>
                            </dd>

                            <dt class="col-sm-4">Status</dt>
                            <dd class="col-sm-8">
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
                            </dd>

                            <dt class="col-sm-4">Purpose</dt>
                            <dd class="col-sm-8">{{ $donation->purpose ?? 'General Fund' }}</dd>

                            <dt class="col-sm-4">Remaining</dt>
                            <dd class="col-sm-8">
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
                            </dd>
                        </dl>
                    </div>
                </div>

                @if($donation->remaining_amount > 0)
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h3 class="card-title h5 mb-0">Allocate Funds</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('donations.allocate', $donation) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" 
                                           step="0.01" min="0.01" max="{{ $donation->remaining_amount }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="allocated_to" class="form-label">Allocate To</label>
                                    <input type="text" class="form-control" id="allocated_to" name="allocated_to" required>
                                </div>
                                <div class="mb-3">
                                    <label for="allocation_type" class="form-label">Type</label>
                                    <select class="form-select" id="allocation_type" name="allocation_type" required>
                                        <option value="">Select Type</option>
                                        <option value="pet_care">Pet Care</option>
                                        <option value="medical">Medical</option>
                                        <option value="food">Food</option>
                                        <option value="shelter_maintenance">Shelter Maintenance</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="2" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-share"></i> Allocate Funds
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Allocations List -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h3 class="card-title h5 mb-0">Fund Allocations</h3>
                    </div>
                    <div class="card-body">
                        @if($donation->allocations->isEmpty())
                            <div class="text-center py-4 text-muted">
                                No allocations yet.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Allocated To</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($donation->allocations as $allocation)
                                            <tr>
                                                <td>{{ $allocation->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <span class="badge bg-success">
                                                        {{ $donation->currency }} {{ number_format($allocation->amount, 2) }}
                                                    </span>
                                                </td>
                                                <td>{{ $allocation->allocated_to }}</td>
                                                <td>
                                                    <span class="badge bg-info">
                                                        {{ str_replace('_', ' ', ucfirst($allocation->allocation_type)) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($allocation->status === 'pending')
                                                        <span class="badge bg-warning">Pending Approval</span>
                                                    @elseif($allocation->status === 'approved')
                                                        <span class="badge bg-success">
                                                            Approved by {{ $allocation->approver->name }}
                                                            <br>
                                                            <small>{{ $allocation->approved_at->format('M d, Y H:i') }}</small>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($allocation->status === 'pending')
                                                        <form action="{{ route('donations.approve-allocation', $allocation) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                <i class="fas fa-check"></i> Approve
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
