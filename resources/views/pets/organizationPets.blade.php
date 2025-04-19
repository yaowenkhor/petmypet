@extends('layouts.auth')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-1 rounded shadow-sm">
                    <div class="card-header bg-white text-center">
                        <h2 class="text-primary fw-bold" style="font-size: 30px; padding-top: 20px; padding-bottom: 15px;">
                            {{ __('My Pets') }}
                        </h2>
                    </div>

                    <div class="card-body p-5">
                        <div class="text-center">
                            <a href="{{ route('organization.home') }}" class="btn btn-outline-secondary me-2">
                                Back to Home
                            </a>
                            <a href="{{ route('pet.index') }}" class="btn btn-outline-primary">
                                View All Pets
                            </a>
                            <a href="{{ route('pet.create.form') }}" class="btn btn-outline-primary ms-2">
                                Add New Pet
                            </a>
                        </div>
                        <br><br>

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
                                <p class="text-muted">No pets found. Add a new pet to get started!</p>
                                <a href="{{ route('pet.create.form') }}" class="btn btn-outline-primary">Add New Pet</a>
                            </div>
                        @else
                            <div class="row">
                                @foreach ($pets as $pet)
                                    <div class="col-md-6 mb-4">
                                        <div class="card mb-3 shadow" style="max-width: 540px;">
                                            <div class="row g-0">
                                                <div class="col-md-4">
                                                    <img src="{{ asset('storage/' . $pet->images->first()->image_path) }}"
                                                        class="img-fluid rounded-start" alt="Pet Image"
                                                        style="height: 100%; width: 100%; object-fit: cover;">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $pet->name }}</h5>
                                                        <p class="card-text">
                                                            <strong>Species:</strong> {{ ucfirst($pet->species) }}<br>
                                                            <strong>Age:</strong> {{ $pet->age }}<br>
                                                            <strong>Status:</strong>
                                                            <span
                                                                class="badge {{ $pet->status === 'available' ? 'bg-success' : 'bg-secondary' }}">
                                                                {{ ucfirst($pet->status) }}
                                                            </span>
                                                        </p>
                                                        <div class="d-flex">
                                                            <a href="{{ route('pet.update', $pet->id) }}"
                                                                class="btn btn-outline-primary btn-sm me-2">Edit</a>
                                                            <form action="{{ route('pet.delete', $pet->id) }}" method="POST"
                                                                class="d-inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                                                    onclick="return confirm('Are you sure you want to delete this pet?')">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection