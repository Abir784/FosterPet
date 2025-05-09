<x-app-layout>
    <div class="m-5 dashboard-section-container grid grid-cols-1 md:grid-cols-3 gap-6">
        @if($user_role === 'pet shelter')
            {{-- Pet Count Card --}}
            <div class="feature-card text-center p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <h5 class="text-xl font-semibold mb-4">🐾 Total Pets Listed</h5>
                <p class="text-6xl font-extrabold text-blue-600">
                    <b>{{ $pet_count }}</b>
                </p>
                <p class="mt-4 text-gray-600">Pets currently listed under your shelter</p>
            </div>

            {{-- Total Adoption Requests Card --}}
            <div class="feature-card text-center p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <h5 class="text-xl font-semibold mb-4">📄 Total Adoption Requests</h5>
                <p class="text-6xl font-extrabold text-green-600">
                   <b>{{ $adoption_request_count }}</b>
                </p>
                <p class="mt-4 text-gray-600">Total requests received for your pets</p>
            </div>

            {{-- Pending Requests Card --}}
            <div class="feature-card text-center p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <h5 class="text-xl font-semibold mb-4">⏳ Pending Requests</h5>
                <p class="text-6xl font-extrabold text-yellow-600">
                   <b>{{ $pending_requests }}</b>
                </p>
                <p class="mt-4 text-gray-600">Requests awaiting your response</p>
            </div>

        @elseif($user_role === 'adopter')
            {{-- Submitted Requests Card --}}
            <div class="feature-card text-center p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <h5 class="text-xl font-semibold mb-4">📝 Total Applications</h5>
                <p class="text-6xl font-extrabold text-blue-600">
                    <b>{{ $submitted_requests }}</b>
                </p>
                <p class="mt-4 text-gray-600">Total adoption applications submitted</p>
            </div>

            {{-- Pending Applications Card --}}
            <div class="feature-card text-center p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <h5 class="text-xl font-semibold mb-4">⏳ Pending Applications</h5>
                <p class="text-6xl font-extrabold text-yellow-600">
                   <b>{{ $pending_requests }}</b>
                </p>
                <p class="mt-4 text-gray-600">Applications awaiting shelter response</p>
            </div>

            {{-- Approved Applications Card --}}
            <div class="feature-card text-center p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <h5 class="text-xl font-semibold mb-4">✅ Approved Applications</h5>
                <p class="text-6xl font-extrabold text-green-600">
                   <b>{{ $approved_requests }}</b>
                </p>
                <p class="mt-4 text-gray-600">Successfully approved adoptions</p>
            </div>
        @endif
        <div class="feature-card text-center p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <h5 class="text-xl font-semibold mb-4">💬 Messages</h5>
            <div class="unread-count text-6xl font-extrabold text-purple-600">
                <b>0</b>
            </div>
            <p class="mt-4 text-gray-600">Unread messages in your inbox.</p>
            <a href="{{ route('messages.index') }}" class="mt-4 inline-block px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-150">
                Open Messages
            </a>
        </div>
    </div>

    {{-- Donation Allocations Section (only shown when coming from My Donations) --}}
    @if(isset($donations) && isset($totalDonated))
    <div class="mt-10 px-6">
        <h2 class="text-2xl font-bold mb-6">Your Donation Allocations</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- Total Donated Card --}}
            <div class="feature-card text-center p-8">
                <h5 class="text-xl font-semibold mb-4">💰 Total Donated</h5>
                <p class="text-6xl font-extrabold text-green-600">
                    <b>${{ number_format($totalDonated, 2) }}</b>
                </p>
                <p class="mt-4 text-gray-600">Total amount you have donated</p>
            </div>
            
            {{-- Total Allocated Card --}}
            <div class="feature-card text-center p-8">
                <h5 class="text-xl font-semibold mb-4">📊 Total Allocated</h5>
                <p class="text-6xl font-extrabold text-blue-600">
                    <b>${{ number_format($totalAllocated, 2) }}</b>
                </p>
                <p class="mt-4 text-gray-600">Amount allocated to various causes</p>
            </div>
            
            {{-- Remaining Unallocated Card --}}
            <div class="feature-card text-center p-8">
                <h5 class="text-xl font-semibold mb-4">⏳ Remaining</h5>
                <p class="text-6xl font-extrabold text-purple-600">
                    <b>${{ number_format($totalDonated - $totalAllocated, 2) }}</b>
                </p>
                <p class="mt-4 text-gray-600">Amount pending allocation</p>
            </div>
        </div>
        
        {{-- Allocation by Type Chart --}}
        @if(count($allocationTypes) > 0)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-semibold mb-4">Allocation by Purpose</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <canvas id="allocationChart" width="400" height="300"></canvas>
                </div>
                <div>
                    <h4 class="text-lg font-medium mb-3">Breakdown</h4>
                    <div class="space-y-2">
                        @foreach($allocationTypes as $type => $amount)
                        <div class="flex justify-between items-center">
                            <span class="capitalize">{{ str_replace('_', ' ', $type) }}</span>
                            <span class="font-semibold">${{ number_format($amount, 2) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        {{-- Donations List --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-semibold mb-4">Your Donations</h3>
            
            @if($donations->isEmpty())
                <p class="text-gray-600">You haven't made any donations yet.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Purpose</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Allocations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donations as $donation)
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $donation->created_at->format('M d, Y') }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">${{ number_format($donation->amount, 2) }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $donation->purpose ?? 'General' }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($donation->status == 'completed') bg-green-100 text-green-800
                                            @elseif($donation->status == 'allocated') bg-blue-100 text-blue-800
                                            @elseif($donation->status == 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        <a href="{{ route('donations.show', $donation->id) }}" class="text-blue-600 hover:text-blue-900">View Details</a>
                                    </td>
                                </tr>
                                
                                {{-- Allocation Details --}}
                                @if($donation->allocations->count() > 0)
                                    <tr>
                                        <td colspan="5" class="py-2 px-4 border-b border-gray-200 bg-gray-50">
                                            <div class="pl-4">
                                                <h5 class="text-sm font-medium mb-2">Allocations:</h5>
                                                <div class="space-y-2">
                                                    @foreach($donation->allocations as $allocation)
                                                        <div class="flex justify-between items-center text-sm">
                                                            <div>
                                                                <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $allocation->allocation_type)) }}</span> - 
                                                                <span class="text-gray-600">{{ $allocation->description }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="font-semibold">${{ number_format($allocation->amount, 2) }}</span>
                                                                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                    @if($allocation->status == 'approved') bg-green-100 text-green-800
                                                                    @elseif($allocation->status == 'pending') bg-yellow-100 text-yellow-800
                                                                    @else bg-gray-100 text-gray-800 @endif">
                                                                    {{ ucfirst($allocation->status) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $donations->links() }}
                </div>
            @endif
        </div>
    </div>
    @endif

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function updateUnreadCount() {
            fetch('{{ route("messages.unread-count") }}')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('.unread-count b').textContent = data.count;
                });
        }

        // Update count every 30 seconds
        setInterval(updateUnreadCount, 30000);
        // Initial update
        updateUnreadCount();
        
        // Allocation chart
        @if(isset($allocationTypes) && count($allocationTypes) > 0)
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('allocationChart').getContext('2d');
            
            const allocationChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [@foreach($allocationTypes as $type => $amount)'{{ ucfirst(str_replace('_', ' ', $type)) }}',@endforeach],
                    datasets: [{
                        data: [@foreach($allocationTypes as $amount){{ $amount }},@endforeach],
                        backgroundColor: [
                            '#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899',
                            '#3B82F6', '#14B8A6', '#F97316', '#DC2626', '#7C3AED', '#DB2777'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: true,
                            text: 'Donation Allocations by Type'
                        }
                    }
                }
            });
        });
        @endif
    </script>
    @endpush
</x-app-layout>
