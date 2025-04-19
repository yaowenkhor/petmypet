@extends('layouts.auth')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-1 rounded shadow-sm">
                <div class="card-header bg-white text-center" style="padding-top: 20px; padding-bottom: 15px;">
                    <h2 class="text-primary fw-bold">{{ $pets->name }}</h2>
                </div>

                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        @if ($pets->images->isNotEmpty())
                            <div class="row">
                                @foreach ($pets->images as $image)
                                    <div class="col-md-6 mb-3">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             class="img-fluid rounded" 
                                             alt="Pet Image" 
                                             style="max-height: 300px; object-fit: cover; width: 100%;">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No images available for this pet.</p>
                        @endif
                    </div>

                    <p><strong>Species:</strong> {{ ucfirst($pets->species) }}</p>
                    <p><strong>Age:</strong> {{ $pets->age }} years</p>
                    <p><strong>Breed:</strong> {{ $pets->breed }}</p>
                    <p><strong>Size:</strong> {{ $pets->size }}</p>
                    <p><strong>Location:</strong> {{ $pets->location }}</p>
                    <p><strong>Temperament:</strong> {{ $pets->temperament ?? 'N/A' }}</p>
                    <p><strong>Medical History:</strong> {{ $pets->medical_history ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge {{ $pets->status === 'available' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($pets->status) }}
                        </span>
                    </p>

                    <div class="text-center mt-4">
                        <a href="{{ route('pet.index') }}" class="btn btn-outline-secondary">Back to All Pets</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection