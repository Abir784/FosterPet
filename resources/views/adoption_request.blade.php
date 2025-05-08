<x-app-layout>
<div class="container">
    <h2 class="mb-4">Manage Pet Adoption Status</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($pets as $pet)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/' . $pet->image) }}" class="card-img-top" alt="{{ $pet->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $pet->name }}</h5>
                        <p>Breed: {{ $pet->breed }}</p>
                        <p>Age: {{ $pet->age }}</p>
                        <p>Status: <strong>{{ $pet->status }}</strong></p>

                 

                        <form method="POST" action="{{ route('adoption.update', $pet->id) }}" id="form-{{ $pet->id }}" class="d-none">
                            @csrf
                            <select name="status" class="form-control" onchange="document.getElementById('form-{{ $pet->id }}').submit();">
                                <option value="" disabled selected>Select status</option>
                                <option value="Available">Available</option>
                                <option value="Pending">Pending</option>
                                <option value="Adopted">Adopted</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function toggleDropdown(petId) {
        const form = document.getElementById('form-' + petId);
        form.classList.toggle('d-none');
    }
</script>
</x-app-layout>

