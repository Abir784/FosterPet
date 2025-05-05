<x-app-layout>
    <div class="m-5 dashboard-section-container grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Pet Count Card --}}
        <div class="feature-card text-center p-8">
            <h5 class="text-xl font-semibold mb-4">🐾 Total Pets You Own</h5>
            <p class="text-6xl font-extrabold text-blue-600">
                <b>{{ $pet_count }}</b>
            </p>
            <p class="mt-4 text-gray-600">Pets currently listed under your ownership.</p>
        </div>

        {{-- Adoption Requests Count Card --}}
        <div class="feature-card text-center p-8">
            <h5 class="text-xl font-semibold mb-4">📄 Adoption Requests for Your Pets</h5>
            <p class="text-6xl font-extrabold text-green-600">
               <b> {{ $adoption_request_count }} </b>
            </p>
            <p class="mt-4 text-gray-600">Total requests submitted to adopt your pets.</p>
        </div>

        {{-- Messages Card --}}
        <div class="feature-card text-center p-8">
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

    @push('scripts')
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
    </script>
    @endpush
</x-app-layout>
