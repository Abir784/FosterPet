<!-- resources/views/pet_list.blade.php -->

<x-app-layout>
<div class="container">
    <div class="mb-5 status-section">
        <h2>🐶 Applications</h2>
        <div class="row">
            @foreach ($requests as $req )
            <div class="mb-4 col-md-4">
                <div class="shadow-sm card h-100">
                    <img src="#" class="card-img-top" alt="#">
                    <div class="card-body">
                        <h5 class="card-title">#</h5>
                        <p class="card-text">
                            AdoptionId: {{ $req->id}} <br>
                            Adopter Name: {{ $req->adopter->name}}<br>
                            Status:<br>
                            <span class="badge bg-success"> {{ $req->status}}</span>
                        </p>
                        <br>
                        @if ($req->status != 'Adopted')
                        <button class="mb-2 btn btn-outline-primary w-100" onclick="toggleDropdown({{ $req->id }})">
                            Change Status
                        </button>
                        <br>

                     <form method="POST" action="{{ route('adoption.update', $req->id) }}" id="form-{{ $req->id }}" class="d-none">
                         @csrf
                         <select name="status" class="form-control" onchange="document.getElementById('form-{{ $req->id }}').submit();">
                             <option value="" disabled selected>Select status</option>
                             <option value="Available">Available</option>
                             <option value="Pending">Pending</option>
                             <option value="Adopted">Adopted</option>
                            </select>
                        </form>
                    @endif
                        <br>
                        <a href="{{ route('adoption.show', $req->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

<script>
    function toggleDropdown(adoptionID) {
        // Make sure to get the specific form by its exact ID
        const formId = 'form-' + adoptionID;
        const form = document.getElementById(formId);
        if (form) {
            form.classList.toggle('d-none');
        } else {
            console.error('Form not found with ID:', formId);
        }
    }
</script>
</x-app-layout>
