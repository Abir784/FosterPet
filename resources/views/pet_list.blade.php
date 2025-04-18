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
                        <a href="#" class="btn btn-primary mb-4 mt-4">Change Status</a> <br>
                        <a href="#" class="btn btn-primary">View  Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
