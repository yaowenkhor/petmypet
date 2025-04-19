@extends('layouts.auth')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="text-center mb-4">
                <h2 class="text-primary fw-bold">All Pets</h2>
                <p class="text-muted">Browse through all the pets available for adoption.</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success text-center" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger text-center" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($pets->isEmpty())
                <div class="text-center">
                    <p class="text-muted">No pets found. Please check back later!</p>
                </div>
            @else
                <div class="row">
                    @foreach ($pets as $pet)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm">
                                <img src="{{ asset('storage/' . $pet->images->first()->image_path) }}" 
                                     class="card-img-top" 
                                     alt="Pet Image" 
                                     style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $pet->name }}</h5>
                                    <p class="card-text">
                                        <strong>Species:</strong> {{ ucfirst($pet->species) }}<br>
                                        <strong>Age:</strong> {{ $pet->age }} years<br>
                                        <strong>Breed:</strong> {{ $pet->breed }}<br>
                                        <strong>Status:</strong> 
                                        <span class="badge {{ $pet->status === 'available' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($pet->status) }}
                                        </span>
                                    </p>
                                    <a href="{{ route('pet.details', $pet->id) }}" class="btn btn-outline-primary btn-sm">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection