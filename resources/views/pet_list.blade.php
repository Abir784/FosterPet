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
                            AdoptionId: {{ $req->adoptionID}} <br>
                            Adopter Name: {{ $req->adopter->name}}<br>
                            Status:<br>
                            <span class="badge bg-success"> {{ $req->status}}</span>
                        </p>
                        <a href="#" class="mt-4 mb-4 btn btn-primary">Change Status</a> <br>
                        <a href="#" class="btn btn-primary">View  Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
