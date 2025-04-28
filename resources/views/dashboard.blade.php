<x-app-layout>
    <div class="m-5 dashboard-section-container grid grid-cols-1 md:grid-cols-2 gap-6">

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
    </div>
</x-app-layout>
