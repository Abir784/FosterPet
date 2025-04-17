@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4 shadow-sm px-3 rounded">
        <a class="navbar-brand" href="#">🐾 Foster Pets</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('adoption.index') }}">Adoption Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="/pets">All Pets</a></li>
            </ul>
        </div>
    </nav>

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

                        <form method="POST" action="{{ route('adoption.update', $pet->id) }}">
                            @csrf
                            <div class="form-group">
                                <label>Status:</label>
                                <select name="status" class="form-control mb-2">
                                    <option value="Available" {{ $pet->status == 'Available' ? 'selected' : '' }}>Available</option>
                                    <option value="Pending" {{ $pet->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Adopted" {{ $pet->status == 'Adopted' ? 'selected' : '' }}>Adopted</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
