<x-app-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">🎁 My Donations & Allocations</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Donation Summary -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <i class="fas fa-gift fa-3x text-primary"></i>
                        </div>
                        <h3 class="card-title h5">Total Donated</h3>
                        <div class="display-6 fw-bold text-success mb-0">
                            ${{ number_format($totalDonated, 2) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <i class="fas fa-chart-pie fa-3x text-primary"></i>
                        </div>
                        <h3 class="card-title h5">Total Allocated</h3>
                        <div class="display-6 fw-bold text-success mb-0">
                            ${{ number_format($totalAllocated, 2) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <i class="fas fa-percentage fa-3x text-primary"></i>
                        </div>
                        <h3 class="card-title h5">Allocation Progress</h3>
                        <div class="display-6 fw-bold text-success mb-0">
                            @php
                                $percentage = $totalDonated > 0 ? ($totalAllocated / $totalDonated) * 100 : 0;
                            @endphp
                            {{ number_format($percentage, 1) }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Allocation Breakdown Chart -->
        @if(count($allocationTypes) > 0)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h3 class="h5 mb-4">Your Donation Allocation Breakdown</h3>
                <div class="row">
                    <div class="col-md-5">
                        <div class="chart-container">
                            <canvas id="userDonationChart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Allocation Type</th>
                                        <th class="text-end">Amount</th>
                                        <th class="text-end">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allocationTypes as $type => $amount)
                                        @php
                                            $typePercentage = $totalAllocated > 0 ? ($amount / $totalAllocated) * 100 : 0;
                                            
                                            // Determine color based on allocation type
                                            $color = 'primary';
                                            if (strpos($type, 'medical') !== false || strpos($type, 'health') !== false) {
                                                $color = 'danger';
                                            } elseif (strpos($type, 'food') !== false || strpos($type, 'nutrition') !== false) {
                                                $color = 'success';
                                            } elseif (strpos($type, 'shelter') !== false || strpos($type, 'housing') !== false) {
                                                $color = 'info';
                                            } elseif (strpos($type, 'rescue') !== false) {
                                                $color = 'warning';
                                            } elseif (strpos($type, 'training') !== false || strpos($type, 'education') !== false) {
                                                $color = 'secondary';
                                            } elseif (strpos($type, 'transport') !== false) {
                                                $color = 'dark';
                                            }
                                        @endphp
                                        <tr>
                                            <td>
                                                <span class="badge bg-{{ $color }} me-2"></span>
                                                {{ ucwords(str_replace('_', ' ', $type)) }}
                                            </td>
                                            <td class="text-end">${{ number_format($amount, 2) }}</td>
                                            <td class="text-end">{{ number_format($typePercentage, 1) }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Individual Donations -->
        <h3 class="h5 mb-3">Your Donation History</h3>
        @forelse($donations as $donation)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="h6 mb-0">Donation #{{ $donation->id }}</h4>
                            <small class="text-muted">{{ $donation->created_at->format('F d, Y') }}</small>
                        </div>
                        <div>
                            <span class="badge bg-success">{{ $donation->currency }} {{ number_format($donation->amount, 2) }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Purpose:</strong> {{ $donation->purpose ?? 'General Fund' }}</p>
                            <p class="mb-1"><strong>Payment Method:</strong> {{ $donation->payment_method }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Status:</strong> 
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'received' => 'info',
                                        'allocated' => 'primary',
                                        'completed' => 'success'
                                    ];
                                    $color = $statusColors[$donation->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ ucfirst($donation->status) }}</span>
                            </p>
                            <p class="mb-1"><strong>Remaining Amount:</strong> {{ $donation->currency }} {{ number_format($donation->remaining_amount, 2) }}</p>
                        </div>
                    </div>
                    
                    <!-- Allocation Progress -->
                    <div class="mb-3">
                        <p class="mb-1"><strong>Allocation Progress:</strong></p>
                        <div class="progress" style="height: 20px;">
                            @php
                                $allocatedAmount = $donation->amount - $donation->remaining_amount;
                                $percentage = $donation->amount > 0 ? ($allocatedAmount / $donation->amount) * 100 : 0;
                            @endphp
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                                role="progressbar"
                                style="width: {{ $percentage }}%"
                                aria-valuenow="{{ $percentage }}"
                                aria-valuemin="0"
                                aria-valuemax="100">
                                {{ number_format($percentage, 1) }}% Allocated
                            </div>
                        </div>
                    </div>
                    
                    <!-- Allocations -->
                    @if($donation->allocations->count() > 0)
                        <h5 class="h6 mt-4 mb-3">Allocation Details</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Allocated To</th>
                                        <th>Description</th>
                                        <th class="text-end">Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($donation->allocations as $allocation)
                                        <tr>
                                            <td>
                                                @php
                                                    // Determine icon and color based on allocation type
                                                    $icon = 'paw';
                                                    $color = 'primary';
                                                    
                                                    if (strpos($allocation->allocation_type, 'medical') !== false || strpos($allocation->allocation_type, 'health') !== false) {
                                                        $icon = 'stethoscope';
                                                        $color = 'danger';
                                                    } elseif (strpos($allocation->allocation_type, 'food') !== false || strpos($allocation->allocation_type, 'nutrition') !== false) {
                                                        $icon = 'utensils';
                                                        $color = 'success';
                                                    } elseif (strpos($allocation->allocation_type, 'shelter') !== false || strpos($allocation->allocation_type, 'housing') !== false) {
                                                        $icon = 'home';
                                                        $color = 'info';
                                                    } elseif (strpos($allocation->allocation_type, 'rescue') !== false) {
                                                        $icon = 'life-ring';
                                                        $color = 'warning';
                                                    } elseif (strpos($allocation->allocation_type, 'training') !== false || strpos($allocation->allocation_type, 'education') !== false) {
                                                        $icon = 'graduation-cap';
                                                        $color = 'secondary';
                                                    } elseif (strpos($allocation->allocation_type, 'transport') !== false) {
                                                        $icon = 'truck';
                                                        $color = 'dark';
                                                    }
                                                @endphp
                                                <i class="fas fa-{{ $icon }} text-{{ $color }} me-1"></i>
                                                {{ ucwords(str_replace('_', ' ', $allocation->allocation_type)) }}
                                            </td>
                                            <td>{{ $allocation->allocated_to }}</td>
                                            <td>{{ $allocation->description }}</td>
                                            <td class="text-end">${{ number_format($allocation->amount, 2) }}</td>
                                            <td>
                                                @php
                                                    $allocationStatusColors = [
                                                        'pending' => 'warning',
                                                        'approved' => 'success',
                                                        'rejected' => 'danger'
                                                    ];
                                                    $allocationColor = $allocationStatusColors[$allocation->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $allocationColor }}">{{ ucfirst($allocation->status) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> This donation has not been allocated yet.
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('donations.show', $donation) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i> View Full Details
                    </a>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> You haven't made any donations yet.
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-4">
            {{ $donations->links() }}
        </div>
    </div>

    <!-- Chart Initialization Script -->
    @if(count($allocationTypes) > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get allocation data from PHP
            const allocationData = {
                @foreach($allocationTypes as $type => $amount)
                    '{{ ucwords(str_replace('_', ' ', $type)) }}': {{ $amount }},
                @endforeach
            };
            
            // Set up colors for chart
            const backgroundColors = [
                '#dc3545', // danger
                '#28a745', // success
                '#17a2b8', // info
                '#ffc107', // warning
                '#6c757d', // secondary
                '#343a40', // dark
                '#007bff'  // primary
            ];
            
            // Create the chart
            const ctx = document.getElementById('userDonationChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(allocationData),
                    datasets: [{
                        data: Object.values(allocationData),
                        backgroundColor: backgroundColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: $${value.toFixed(2)} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '70%',
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        });
    </script>
    @endif
</x-app-layout>
