

<x-app-layout>
    <div class="container">
        <div class="mb-5 status-section">
            <h2>🐶 Track Applications</h2>
            <div class="row">
                @foreach ($adoption_requests as $req )
                <div class="mb-4 col-md-4">
                    <div class="shadow-sm card h-100">
                        <img src={{asset(App\Models\pets::where('id',$req->adoption->pet_id)->get('image')[0]['image'])}}    class="card-img-top" alt="{{App\Models\pets::where('id',$req->adoption->pet_id)->get('image')[0]['image']}}">
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <p class="card-text">
                                Pet Name: {{App\Models\pets::where('id',$req->adoption->pet_id)->get('name')[0]['name']}} <br>
                                Adopter Name: {{ $req->adopter->name}}<br>
                                Status:<br>
                                <span class="badge bg-success"> {{ $req->status}}</span>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </x-app-layout>
