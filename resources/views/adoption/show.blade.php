<x-app-layout>
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Adoption Request Details</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Pet Information -->
                        <div class="col-md-6">
                            <h3 class="h5 mb-3">Pet Information</h3>
                            @if($adoptionRequest->adoption->pet->image)
                                <img src="{{ asset($adoptionRequest->adoption->pet->image) }}" 
                                     alt="{{ $adoptionRequest->adoption->pet->name }}" 
                                     class="img-fluid rounded mb-3" style="max-height: 300px;">
                            @endif
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Name:</strong> {{ $adoptionRequest->adoption->pet->name }}</li>
                                <li class="list-group-item"><strong>Breed:</strong> {{ $adoptionRequest->adoption->pet->breed }}</li>
                                <li class="list-group-item"><strong>Age:</strong> {{ $adoptionRequest->adoption->pet->age }} Months</li>
                                <li class="list-group-item"><strong>Type:</strong> {{ $adoptionRequest->adoption->pet->type }}</li>
                                <li class="list-group-item"><strong>Color:</strong> {{ $adoptionRequest->adoption->pet->color }}</li>
                                <li class="list-group-item"><strong>Health Condition:</strong> {{ $adoptionRequest->adoption->pet->health_condition }}</li>
                                <li class="list-group-item"><strong>Temperament:</strong> {{ $adoptionRequest->adoption->pet->temperament }}</li>
                                <li class="list-group-item"><strong>Location:</strong> {{ $adoptionRequest->adoption->pet->location }}</li>
                                <li class="list-group-item"><strong>Remarks:</strong> {{ $adoptionRequest->adoption->pet->remarks }}</li>
                            </ul>
                        </div>

                        <!-- Adopter Information -->
                        <div class="col-md-6">
                            <h3 class="h5 mb-3">Adopter Information</h3>
                            <ul class="list-group list-group-flush mb-4">
                                <li class="list-group-item"><strong>Name:</strong> {{ $adoptionRequest->adopter->name }}</li>
                                <li class="list-group-item"><strong>Email:</strong> {{ $adoptionRequest->adopter->email }}</li>
                                <li class="list-group-item">
                                    <strong>Status:</strong>
                                    <span class="badge bg-{{ $adoptionRequest->status === 'Approved' ? 'success' : ($adoptionRequest->status === 'Pending' ? 'warning' : 'secondary') }}">
                                        {{ $adoptionRequest->status }}
                                    </span>
                                </li>
                            </ul>

                            <!-- Applicant Type Information -->
                            @if($adoptionRequest->applicantType)
                                <h4 class="h5 mt-4 mb-3">Foster Application Details</h4>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <strong>Foster Type:</strong> 
                                        {{ ucfirst(str_replace('-', ' ', $adoptionRequest->applicantType->foster_type)) }}
                                    </li>
                                    @if($adoptionRequest->applicantType->foster_type === 'short-term')
                                        <li class="list-group-item"><strong>Duration:</strong> {{ $adoptionRequest->applicantType->duration }} weeks</li>
                                        <li class="list-group-item"><strong>Temporary Address:</strong> {{ $adoptionRequest->applicantType->temporary_address }}</li>
                                    @else
                                        <li class="list-group-item"><strong>Employment Status:</strong> {{ $adoptionRequest->applicantType->employment_status }}</li>
                                        <li class="list-group-item"><strong>Housing Status:</strong> {{ $adoptionRequest->applicantType->housing_status }}</li>
                                    @endif
                                </ul>
                            @endif

                            <!-- Documents Section -->
                            @if($adoptionRequest->documents->count() > 0)
                                <h4 class="h5 mt-4 mb-3">Submitted Documents</h4>
                                <div class="list-group">
                                    @foreach($adoptionRequest->documents as $document)
                                        <a href="{{ asset('storage/' . $document->file_path) }}" 
                                           class="list-group-item list-group-item-action" 
                                           target="_blank">
                                            Document #{{ $loop->iteration }}
                                            <span class="float-end">
                                                <i class="fas fa-download"></i>
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info mt-3">No documents submitted with this application.</div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('track.requests') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>