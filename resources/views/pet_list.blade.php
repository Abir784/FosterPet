<!-- resources/views/petlist.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">🐶 Pet List</h1>

    <div class="status-section mb-5">
        <h2>Available Pets</h2>
        <div class="row">
            @foreach($pets->where('status', 'Available') as $pet)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $pet->image) }}" class="card-img-top" alt="{{ $pet->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $pet->name }}</h5>
                            <p class="card-text">
                                Breed: {{ $pet->breed }}<br>
                                Age: {{ $pet->age }}<br>
                                Status: 
                                <span class="badge bg-success">{{ $pet->status }}</span>
                            </p>
                            <a href="{{ route('pets.show', $pet->id) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="status-section mb-5">
        <h2>Pending Pets</h2>
        <div class="row">
            @foreach($pets->where('status', 'Pending') as $pet)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $pet->image) }}" class="card-img-top" alt="{{ $pet->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $pet->name }}</h5>
                            <p class="card-text">
                                Breed: {{ $pet->breed }}<br>
                                Age: {{ $pet->age }}<br>
                                Status: 
                                <span class="badge bg-warning">{{ $pet->status }}</span>
                            </p>
                            <a href="{{ route('pets.show', $pet->id) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="status-section">
        <h2>Adopted Pets</h2>
        <div class="row">
            @foreach($pets->where('status', 'Adopted') as $pet)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $pet->image) }}" class="card-img-top" alt="{{ $pet->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $pet->name }}</h5>
                            <p class="card-text">
                                Breed: {{ $pet->breed }}<br>
                                Age: {{ $pet->age }}<br>
                                Status: 
                                <span class="badge bg-secondary">{{ $pet->status }}</span>
                            </p>
                            <a href="{{ route('pets.show', $pet->id) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
