<!-- resources/views/petlist.blade.php -->

<x-app-layout>
<div class="container">
    <div class="status-section mb-5">
        <h2>🐶 Applications</h2>
        <div class="row">
            @foreach ($requests as $req )
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="#" class="card-img-top" alt="#">
                    <div class="card-body">
                        <h5 class="card-title">#</h5>
                        <p class="card-text">
                            AdoptionId: {{ $req->adoptionID}} <br>
                            Adopter Name: {{ $req->adopter->name}}<br>
                            Status:<br>
                            <span class="badge bg-success"> {{ $req->status}}</span>
                        </p>
                        <br>
                        <button class="btn btn-outline-primary w-100 mb-2" onclick="toggleDropdown({{ $req->adoptionID }})">
                            Change Status
                        </button>
                        <br>

                        <form method="POST" action="{{ route('adoption.update', $req->adoptionID) }}" id="form-{{ $req->adoptionID }}" class="d-none">
                            @csrf
                            <select name="status" class="form-control" onchange="document.getElementById('form-{{ $req->adoptionID }}').submit();">
                                <option value="" disabled selected>Select status</option>
                                <option value="Available">Available</option>
                                <option value="Pending">Pending</option>
                                <option value="Adopted">Adopted</option>
                            </select>
                        </form>
                        <br>
                        <a href="#" class="btn btn-primary">View  Details</a>
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
