@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-1 rounded shadow-sm">
                    <div class="card-header bg-white text-center" style="padding-top: 20px; padding-bottom: 15px;">
                        <h2 class="text-primary fw-bold">{{ $pets->name }}</h2>
                    </div>

                    <div class="card-body p-5">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Display Error Message -->
                        @if (session('error'))
                            <div class="alert alert-danger text-center" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="text-center mb-4">
                            @if ($pets->images->isNotEmpty())
                                <div class="row">
                                    @foreach ($pets->images as $image)
                                        <div class="col-md-6 mb-3">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid rounded"
                                                alt="Pet Image" style="max-height: 300px; object-fit: cover; width: 100%;">
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

                        <!-- Button trigger modal -->
                        @if (Auth::guard('adopter')->check())
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#adoptionModal">
                                Request Adoption
                            </button>
                        @endif
                        <!-- Modal -->
                        <div class="modal fade" id="adoptionModal" tabindex="-1" aria-labelledby="adoptionModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="adoptionModalLabel">Adoption Request</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('adoption.submit', $pets->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <p>Would you like to request adoption for <strong>{{ $pets->name }}</strong>?
                                            </p>
                                            <div class="mb-3">
                                                <label for="question" class="form-label">Why would you like to adopt this
                                                    pet?</label>
                                                <textarea class="form-control" id="question" name="question" rows="3"
                                                    required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Submit Request</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('pet.index') }}" class="btn btn-outline-secondary">Back to All Pets</a>
                </div>
            </div>
        </div>
    </div>
@endsection