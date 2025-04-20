@extends('layouts.master')
@php
    $loggedInUser = Auth::user(); // For 'user' or 'organization'
    $adminUser = Auth::guard('admin')->user(); // For admin
@endphp

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                @if ($showGreeting)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        We hope you find your perfect pet companion here! Feel free to explore and let us know if you have
                        any questions.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="text-center mb-4">
                    <h2 class="text-primary fw-bold">All Pets</h2>
                    <p class="text-muted">Browse through all the pets available for adoption.</p>
                    @if (!session('logged_in'))
                        <div class="alert alert-info text-center" role="alert">
                            <strong>Note:</strong> You are currently viewing as a guest. To adopt a pet, please <span><a
                                    href="{{ route('adopter.login.form') }}">log in</a></span> or
                            <span><a href="{{ route('adopter.register.form') }}">register</a></span>.
                        </div>
                    @endif

                    <form action="{{ route('pet.search') }}" method="GET" class="d-flex justify-content-center mb-3">
                        <input type="text" name="term" class="form-control w-50 me-2"
                            placeholder="Search by pet name..." value="{{ request('term') }}">
                        <select name="age" class="form-select w-auto me-2">
                            <option value="">Filter by Age</option>
                            <option value="asc" {{ request('age') == 'asc' ? 'selected' : '' }}>Youngest First</option>
                            <option value="desc" {{ request('age') == 'desc' ? 'selected' : '' }}>Oldest First</option>
                        </select>

                        <select name="status" class="form-select w-auto me-2">
                            <option value="">Filter by Status</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available
                            </option>
                            <option value="adopted" {{ request('status') == 'adopted' ? 'selected' : '' }}>Adopted</option>
                        </select>

                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
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
                        <hr><br><br>
                        <p class="text-muted">No pets found. Please check back later!</p>
                    </div>
                @else
                    <div class="row">
                        <hr><br><br>
                        @foreach ($pets as $pet)
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm h-100">
                                    <img src="{{ asset('storage/' . $pet->images->first()->image_path) }}"
                                        class="card-img-top" alt="Pet Image" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $pet->name }}</h5>
                                        <p class="card-text mb-2">
                                            <strong>Species:</strong> {{ ucfirst($pet->species) }}<br>
                                            <strong>Age:</strong> {{ $pet->age }} years<br>
                                            <strong>Breed:</strong> {{ $pet->breed }}<br>
                                            <strong>Status:</strong>
                                            <span
                                                class="badge {{ $pet->status === 'available' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($pet->status) }}
                                            </span>
                                        </p>
                                        <a href="{{ route('pet.details', $pet->id) }}"
                                            class="btn btn-outline-primary btn-sm w-100">
                                            View Details
                                        </a>

                                        <!-- Admin Delete Button -->
                                        @if (Auth::guard('admin')->check())
                                            <form action="{{ route('admin.pets.delete', $pet->id) }}" method="POST" class="mt-2"
                                                onsubmit="return confirm('Are you sure you want to delete this pet?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm w-100">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $pets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
